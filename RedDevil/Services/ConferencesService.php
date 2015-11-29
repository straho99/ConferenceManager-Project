<?php

namespace RedDevil\Services;

use RedDevil\Config\DatabaseConfig;
use RedDevil\Core\DatabaseData;
use RedDevil\Core\HttpContext;
use RedDevil\InputModels\Conference\BatchBookLectures;
use RedDevil\InputModels\Conference\ConferenceInputModel;
use RedDevil\InputModels\Venue\VenueRequestInputModel;
use RedDevil\Models\Conference;
use RedDevil\Models\Notification;
use RedDevil\Models\VenueReservationRequest;
use RedDevil\ViewModels\ConferenceDetailsViewModel;
use RedDevil\ViewModels\ConferenceSummaryViewModel;
use RedDevil\ViewModels\LectureViewModel;

class ConferencesService extends BaseService
{

    public function getAllConferences()
    {
        $conferenceModels = [];
        $conferences = $this->dbContext->getConferencesRepository()
            ->orderByDescending('StartDate')
            ->findAll();

        foreach ($conferences->getConferences() as $conference) {
            $venueId = $conference->getVenue_Id();
            $venue = $this->dbContext->getVenuesRepository()
                ->filterById(" = $venueId")
                ->findOne()
                ->getTitle();
            $ownerId = $conference->getOwnerId();
            $owner = $this->dbContext->getUsersRepository()
                ->filterById(" = $ownerId")
                ->findOne()
                ->getUsername();
            $model = new ConferenceSummaryViewModel($conference);
            $model->setVenue($venue);
            $model->setOwnerUsername($owner);
            $conferenceModels[] = $model;
        }

        return $conferenceModels;
    }

    /**
     * @param ConferenceInputModel $model
     * @return ServiceResponse
     * @throws \Exception
     */
    public function addConference(ConferenceInputModel $model) : ServiceResponse
    {
        if (strtotime($model->getEndDate()) <= strtotime($model->getStartDate())) {
            return new ServiceResponse(1, 'End date must be after Start date.');
        }

        $conference = new Conference(
            $model->getTitle(),
            $model->getStartDate(),
            $model->getEndDate(),
            HttpContext::getInstance()->getIdentity()->getUserId(),
            null
        );
        $this->dbContext->getConferencesRepository()
            ->add($conference);
        $this->dbContext->saveChanges();

        $title = $model->getTitle();
        $organiser = HttpContext::getInstance()->getIdentity()->getUsername();
        $message = "New conference titled '$title' was added by user $organiser.";
        $notyService = new NotificationsService($this->dbContext);
        $notyService->postToAll($message);

        return new ServiceResponse(null, 'Conference added successfully.');
    }

    public function getConferenceDetails(integer $conferenceId) : ServiceResponse
    {
        $db = DatabaseData::getInstance(DatabaseConfig::DB_INSTANCE);
        $statement = $db->prepare("select count(LectureId) as 'count' from lecturesParticipants where LectureId = ?");

        $conference = $this->dbContext->getConferencesRepository()
            ->filterById(" = $conferenceId")
            ->findOne();

        if ($conference->getId() == null) {
            return new ServiceResponse(1, "Conference not found.");
        }

        $venueId = $conference->getVenue_Id();
        $venue = $this->dbContext->getVenuesRepository()
            ->filterById(" = $venueId")
            ->findOne()
            ->getTitle();
        $ownerId = $conference->getOwnerId();
        $owner = $this->dbContext->getUsersRepository()
            ->filterById(" = $ownerId")
            ->findOne()
            ->getUsername();
        $model = new ConferenceDetailsViewModel($conference);
        $model->setVenueId($venueId);
        $model->setVenue($venue);
        $model->setOwnerUsername($owner);

        $venueStatus = $this->dbContext->getVenueReservationRequestsRepository()
            ->filterByConferenceId(" = $conferenceId")
            ->filterByVenueId(" = $venueId")
            ->findOne()
            ->getStatus();
        $model->setVenueRequestStatus($venueStatus);

        $lectures = $this->dbContext->getLecturesRepository()
            ->filterByConferenceId(" = $conferenceId")
            ->orderBy("StartDate")
            ->findAll(" = $conferenceId");
        $lecturesModels = [];
        foreach ($lectures->getLectures() as $lecture) {
            $lectureModel = new LectureViewModel($lecture);
            $hallId = $lectureModel->getHallId() == null ? 0 : $lectureModel->getHallId();
            $hall = $this->dbContext->getHallsRepository()
                ->filterById(" = $hallId")
                ->findOne();
            $lectureModel->setHallTitle($hall->getTitle() == null ? "(to be decided)" : $hall->getTitle());

            $speakerId = $lectureModel->getSpeakerId();
            $speaker = $this->dbContext->getUsersRepository()
                ->filterById(" = $speakerId")
                ->findOne();
            $lectureModel->setSpeakerUsername($speaker->getUsername());

            $lectureId = $lecture->getId();
            $speakerRequest = $this->dbContext->getSpeakerInvitationsRepository()
                ->filterByLectureId(" = $lectureId")
                ->filterBySpeakerId(" = $speakerId")
                ->findOne();
            $lectureModel->setSpeakerRequestStatus($speakerRequest->getStatus());

            $lectureId = $lectureModel->getId();
            $statement = $db->prepare("select count(LectureId) as 'count' from lecturesParticipants where LectureId = ?");
            $statement->execute([$lectureId]);
            $participants = $statement->fetch()['count'];
            $lectureModel->setParticipantsCount($participants);

            $participantId = HttpContext::getInstance()->getIdentity()->getUserId();
            if ($participantId == null) {
                $lectureModel->setIsParticipating(false);
                $lectureModel->setCanParticipate(false);
            } else {
                $participantsInLecture = $this->dbContext->getLecturesParticipantsRepository()
                    ->filterByLectureId(" = $lectureId")
                    ->filterByParticipantId(" = $participantId")
                    ->findOne();
                if ($participantsInLecture->getId() != null) {
                    $lectureModel->setIsParticipating(true);
                } else {
                    $lectureModel->setIsParticipating(false);
                }

                $statement = $db->prepare(self::CHECK_USER_CAN_PARTICIPATE);
                $statement->execute(
                    [
                        $participantId,
                        $lecture->getStartDate(),
                        $lecture->getStartDate(),
                        $lecture->getEndDate(),
                        $lecture->getEndDate()
                    ]);
                if ($statement->rowCount() > 0) {
                    $lectureModel->setCanParticipate(false);
                } else {
                    $lectureModel->setCanParticipate(true);
                }

            }


            $lecturesModels[] = $lectureModel;
        }

        $model->setLectures($lecturesModels);
        return $model;
    }

    public function getConferencesForVenue(integer $venueId) : ServiceResponse
    {
        $conferenceModels = [];
        $conferences = $this->dbContext->getConferencesRepository()
            ->filterByVenue_Id(" = $venueId")
            ->orderByDescending('StartDate')
            ->findAll();

        foreach ($conferences->getConferences() as $conference) {
            $venueId = $conference->getVenue_Id();
            $venue = $this->dbContext->getVenuesRepository()
                ->filterById(" = $venueId")
                ->findOne()
                ->getTitle();
            $ownerId = $conference->getOwnerId();
            $owner = $this->dbContext->getUsersRepository()
                ->filterById(" = $ownerId")
                ->findOne()
                ->getUsername();
            $model = new ConferenceSummaryViewModel($conference);
            $model->setVenue($venue);
            $model->setOwnerUsername($owner);
            $conferenceModels[] = $model;
        }

        return $conferenceModels;
    }

    public function sendVenueRequest(VenueRequestInputModel $model) : ServiceResponse
    {
        $conferenceId = $model->getConferenceId();
        $venueId = $model->getVenueId();
        $conference = $this->dbContext->getConferencesRepository()
            ->filterById(" = $conferenceId")
            ->findOne();

        if ($conference->getId() == null) {
            return new ServiceResponse(404, "Conference not found.");
        }

        $venue = $this->dbContext->getVenuesRepository()
            ->filterById(" = $venueId")
            ->findOne();
        if ($venue->getId() == null) {
            return new ServiceResponse(404, "Venue not found.");
        }

        if (HttpContext::getInstance()->getIdentity()->getUserId() != $conference->getOwnerId()) {
            return new ServiceResponse(401, 'Only conference owners are allowed to send venue requests.');
        }

        $testRequest = $this->dbContext->getVenueReservationRequestsRepository()
            ->filterByConferenceId(" = $conferenceId")
            ->filterByVenueId(" = $venueId")
            ->findOne();
        if ($testRequest->getId() != null) {
            return new ServiceResponse(1, "Request for this venue already exists.");
        }

        $this->dbContext->getVenueReservationRequestsRepository()
            ->filterByConferenceId(" = $conferenceId")
            ->delete();

        $conference->setVenue_Id($model->getVenueId());
        $this->dbContext->saveChanges();

        $venueRequest = new VenueReservationRequest($venueId, $conferenceId, 0);
        $this->dbContext->getVenueReservationRequestsRepository()
            ->add($venueRequest);

        $conferenceTitle = $conference->getTitle();
        $venueTitle = $venue->getTitle();
        $message = "You received venue reservation request for venue '$venueTitle' by conference '$conferenceTitle'.";
        $notyService = new NotificationsService($this->dbContext);
        $notyService->sendNotification($venue->getOwnerId(), $message);

        $this->dbContext->saveChanges();

        return new ServiceResponse(null, "Venue request sent successfully.");
    }

    public function deleteConference(integer $conferenceId) : ServiceResponse
    {
        $conference = $this->dbContext->getConferencesRepository()
            ->filterById(" = $conferenceId")
            ->findOne();
        if ($conference->getId() == null) {
            return new ServiceResponse(404, "Conference not found.");
        }

        If (HttpContext::getInstance()->getIdentity()->getUserId() != $conference->getOwnerId() &&
            !HttpContext::getInstance()->getIdentity()->isInRole('admin')) {
            Return new ServiceResponse(401, "Unauthorised. Deleting conferences only allowed for conference owners and admins.");
        }

        $venueRequest = $this->dbContext->getVenueReservationRequestsRepository()
            ->filterByConferenceId(" = $conferenceId")
            ->delete();

        $conferenceLectures = $this->dbContext->getLecturesRepository()
            ->filterByConferenceId(" = $conferenceId")
            ->findAll();

        foreach ($conferenceLectures->getLectures() as $lecture) {
            $lectureId = $lecture->getId();
            $this->dbContext->getSpeakerInvitationsRepository()
                ->filterByLectureId(" = $lectureId")
                ->delete();
            $this->dbContext->getLectureBreaksRepository()
                ->filterByLectureId(" = $lectureId")
                ->delete();
            $this->dbContext->getLecturesParticipantsRepository()
                ->filterByLectureId(" = $lectureId")
                ->delete();
            $lecture->setHall_Id(null);
        }

        $conferenceLectures = $this->dbContext->getLecturesRepository()
            ->filterByConferenceId(" = $conferenceId")
            ->delete();

        $this->dbContext->getConferencesRepository()
            ->filterById(" = $conferenceId")
            ->delete();
        return new ServiceResponse(null, "Conference deleted.");
    }

    public function getUserConferences() : ServiceResponse
    {
        $userId = HttpContext::getInstance()->getIdentity()->getUserId();
        if ($userId == null) {
            return new ServiceResponse(401, "Unauthorised. Only logged-in users can view their conferences.");
        }

        $conferences = $this->dbContext->getConferencesRepository()
            ->filterByOwnerId(" = $userId")
            ->findAll();

        $conferenceModels = [];
        foreach ($conferences->getConferences() as $conference) {
            $venueId = $conference->getVenue_Id();
            $venue = $this->dbContext->getVenuesRepository()
                ->filterById(" = $venueId")
                ->findOne()
                ->getTitle();
            $ownerId = $conference->getOwnerId();
            $owner = $this->dbContext->getUsersRepository()
                ->filterById(" = $ownerId")
                ->findOne()
                ->getUsername();
            $model = new ConferenceSummaryViewModel($conference);
            $model->setVenue($venue);
            $model->setOwnerUsername($owner);
            $conferenceModels[] = $model;
        }

        return new ServiceResponse(null, null, $conferenceModels);
    }

    public function autoSchedule(integer $conferenceId) : ServiceResponse
    {
        $conference = $this->dbContext->getConferencesRepository()
            ->filterById(" = $conferenceId")
            ->findOne();
        if ($conference->getId() == null) {
            return new ServiceResponse(404, 'Conference not found.');
        }

        $lectures = $this->dbContext->getLecturesRepository()
            ->filterByConferenceId(" = $conferenceId")
            ->orderBy("StartDate")
            ->findAll()
            ->getLectures();

        $lectureViewModels = [];
        foreach ($lectures as $lecture) {
            $model = new LectureViewModel($lecture);
            $lectureViewModels[] = $model;
        }

        $result = LongestLecturesSequence::getSequence($lectureViewModels);
        return new ServiceResponse(null, null, $result);

    }

    public function batchBook(BatchBookLectures $lectures) : ServiceResponse
    {
        $lectureService = new LecturesService($this->dbContext);

        $responses = [];

        foreach ($lectures->getLectureIds() as $lectureId) {
            $response = $lectureService->addParticipant($lectureId, HttpContext::getInstance()->getIdentity()->getUserId());
            $responses[] = $response;
        }

        return new ServiceResponse(null, null, $responses);
    }

    const CHECK_USER_CAN_PARTICIPATE = <<<TAG
select lectures.id
from lectures
join lecturesParticipants on lectures.id = lecturesParticipants.LectureId
	where lecturesParticipants.ParticipantId = ? and
		((? >= lectures.startDate and ? <= lectures.endDate) or
			(? >= lectures.startDate and ? <= lectures.endDate))
TAG;
}