<?php

namespace RedDevil\Services;

use RedDevil\Config\DatabaseConfig;
use RedDevil\Core\DatabaseData;
use RedDevil\Core\HttpContext;
use RedDevil\InputModels\Lecture\AddHallInputModel;
use RedDevil\InputModels\Lecture\BreakInputModel;
use RedDevil\InputModels\Lecture\LectureInputModel;
use RedDevil\InputModels\Lecture\SpeakerInvitationInputModel;
use RedDevil\Models\Lecture;
use RedDevil\Models\LectureBreak;
use RedDevil\Models\LecturesParticipant;
use RedDevil\Models\SpeakerInvitation;
use RedDevil\ViewModels\AddBreakViewModel;
use RedDevil\ViewModels\AddHallViewModel;
use RedDevil\ViewModels\LectureViewModel;

class LecturesService extends BaseService
{
    public function addLecture(LectureInputModel $model)
    {
        $lecture = new Lecture(
            $model->getTitle(),
            $model->getDescription(),
            $model->getStartDate(),
            $model->getEndDate(),
            $model->getConferenceId(),
            null,
            null
        );

        $this->dbContext->getLecturesRepository()
            ->add($lecture);
        $this->dbContext->saveChanges();
        return new ServiceResponse(null, "Lecture created successfully.");
    }

    public function deleteLecture($lectureId)
    {
        $lecture = $this->dbContext->getLecturesRepository()
            ->filterById(" = $lectureId")
            ->findOne();
        If ($lecture->getId() == null) {
            Return new ServiceResponse(404, "Lecture not found");
        }

        $conferenceId = $lecture->getConferenceId();
        $conference = $this->dbContext->getConferencesRepository()
            ->filterById(" = $conferenceId")
            ->findOne();

        If (HttpContext::getInstance()->getIdentity()->getUserId() != $conference->getOwnerId()) {
            return new ServiceResponse(401, "Unauthorised. Deleting lectures only allowed for conference owners.");
        }

        $this->dbContext->getSpeakerInvitationsRepository()
            ->filterByLectureId(" = $lectureId")
            ->delete();

        $this->dbContext->getLectureBreaksRepository()
            ->filterByLectureId(" = $lectureId")
            ->delete();

        $this->dbContext->getLecturesParticipantsRepository()
            ->filterByLectureId(" = $lectureId")
            ->delete();

        $this->dbContext->getLecturesRepository()
            ->filterById(" = $lectureId")
            ->delete();
        return new ServiceResponse(null, "Lecture deleted.");
    }

    public function inviteSpeaker(SpeakerInvitationInputModel $model)
    {
        $lectureId = $model->getLectureId();
        $speakerId = $model->getSpeakerId();
        $conferenceId = $model->getConferenceId();
        $lecture = $this->dbContext->getLecturesRepository()
            ->filterById(" = $lectureId")
            ->findOne();
        $speaker = $this->dbContext->getUsersRepository()
            ->filterById(" = $speakerId")
            ->findOne();

        if ($lecture->getId() == null) {
            return new ServiceResponse(404, "Lecture not found.");
        }
        if ($speaker->getId() == null) {
            return new ServiceResponse(404, "Speaker not found.");
        }

        $conference = $this->dbContext->getConferencesRepository()
            ->filterById(" = $conferenceId")
            ->findOne();
        if ($conference->getId() == null) {
            return new ServiceResponse(404, 'Conference not found.');
        }

        if (HttpContext::getInstance()->getIdentity()->getUserId() != $conference->getOwnerId()) {
            return new ServiceResponse(401, 'Only conference owners can invite speakers.');
        }

        $invitation = $this->dbContext->getSpeakerInvitationsRepository()
            ->filterByLectureId(" = $lectureId")
            ->filterBySpeakerId(" = $speakerId")
            ->findOne();
        if ($invitation->getId() != null) {
            return new ServiceResponse(409, "Speaker is already invited.");
        }

        $this->dbContext->getSpeakerInvitationsRepository()
            ->filterByLectureId(" = $lectureId")
            ->delete();

        $speakerInvitation = new SpeakerInvitation(
            $lectureId,
            $speakerId,
            0
        );
        $this->dbContext->getSpeakerInvitationsRepository()
            ->add($speakerInvitation);
        $lecture->setSpeaker_Id($speakerId);

        $title = $lecture->getTitle();
        $message = "You received Speaker invitation for the lecture '$title'.";
        $notyService = new NotificationsService($this->dbContext);
        $notyService->sendNotification($speakerId, $message);

        $this->dbContext->saveChanges();

        return new ServiceResponse(null, "Invitation sent.");
    }

    public function removeSpeaker($lectureId, $speakerId)
    {
        $lecture = $this->dbContext->getLecturesRepository()
            ->filterById(" = $lectureId")
            ->findOne();
        $speaker = $this->dbContext->getUsersRepository()
            ->filterById(" = $speakerId")
            ->findOne();

        if ($lecture->getId() == null) {
            return new ServiceResponse(404, "Lecture not found.");
        }
        if ($speaker->getId() == null) {
            return new ServiceResponse(404, "Speaker not found.");
        }

        $invitation = $this->dbContext->getSpeakerInvitationsRepository()
            ->filterByLectureId(" = $lectureId")
            ->filterBySpeakerId(" = $speakerId")
            ->findOne();
        if ($invitation->getId() == null) {
            return new ServiceResponse(404, "Invitation not found.");
        }

        $invitation = $this->dbContext->getSpeakerInvitationsRepository()
            ->filterByLectureId(" = $lectureId")
            ->filterBySpeakerId(" = $speakerId")
            ->delete();

        return new ServiceResponse(null, "Invitation deleted.");
    }

    public function addHall(AddHallInputModel $model)
    {
        $lectureId = $model->getLectureId();
        $hallId = $model->getHallId();
        $conferenceId = $model->getConferenceId();

        $lecture = $this->dbContext->getLecturesRepository()
            ->filterById(" = $lectureId")
            ->findOne();

        if ($lecture->getId() == null) {
            return new ServiceResponse(404, "Lecture not found.");
        }

        $hall = $this->dbContext->getHallsRepository()
            ->filterById(" = $hallId")
            ->findOne();
        if ($hall->getId() == null) {
            return new ServiceResponse(404, "Hall not found.");
        }

        $conference = $this->dbContext->getConferencesRepository()
            ->filterById(" = $conferenceId")
            ->findOne();

        if (HttpContext::getInstance()->getIdentity()->getUserId() != $conference->getOwnerId()) {
            return new ServiceResponse(401, "Unauthorised. You must be conference owner.");
        }

        $venueId = $conference->getVenue_Id();
        $testHall = $this->dbContext->getHallsRepository()
            ->filterById(" = $hallId")
            ->filterByVenueId(" = $venueId")
            ->findOne();
        if ($testHall->getId() == null) {
            return new ServiceResponse(409, "No such hall in the conference venue.");
        }

        $lectureStartDate = $lecture->getStartDate();
        $lectureEndDate = $lecture->getEndDate();

        $db = DatabaseData::getInstance(DatabaseConfig::DB_INSTANCE);
        $statement = $db->prepare($this::CHECK_HALL_AVAILABILITY);

        $statement->execute(
            [$hallId, $lectureStartDate, $lectureStartDate, $lectureEndDate, $lectureEndDate]);
        if ($statement->rowCount() > 0) {
            return new ServiceResponse(1, "The hall is busy at this time. Request is denied.", $conferenceId);
        }

        $lecture->setHall_Id($hallId);
        $this->dbContext->saveChanges();
        return new ServiceResponse(null, "Hall added to lecture.", $conferenceId);
    }

    public function deleteHall($lectureId)
    {
        $lecture = $this->dbContext->getLecturesRepository()
            ->filterById(" = $lectureId")
            ->findOne();

        if ($lecture->getId() == null) {
            return new ServiceResponse(404, "Lecture not found.");
        }

        $lecture->setHall_Id(null);
        $this->dbContext->saveChanges();

        return new ServiceResponse(null, "Hall removed from lecture.");
    }

    public function addBreak(BreakInputModel $model)
    {
        $lectureId = $model->getLectureId();
        $lecture = $this->dbContext->getLecturesRepository()
            ->filterById(" = $lectureId")
            ->findOne();

        if ($lecture->getId() == null) {
            return new ServiceResponse(404, "Lecture not found.");
        }

        $breakStartDate = strtotime($model->getStartDate());
        $breakEndDate = strtotime($model->getEndDate());

        if ($breakStartDate >= $breakEndDate) {
            return new ServiceResponse(1, "Start date/time cannot be later than End date/time.", $model->getConferenceId());
        }

        $lectureModel = new LectureViewModel($lecture);
        if (!$this->contains($lectureModel, $model)) {
            return new ServiceResponse(1, "Break failed to add. Time is outside lecture time.", $model->getConferenceId());
        }

        $lectureBreaks = $this->dbContext->getLectureBreaksRepository()
            ->filterByLectureId(" = $lectureId")
            ->findAll();

        $conferenceId = $model->getConferenceId();
        foreach ($lectureBreaks->getLectureBreaks() as $break) {
            $otherBreakModel = new AddBreakViewModel($break);
            if ($this->compareTo($model, $otherBreakModel) == 0) {
                return new ServiceResponse(1, "Break failed to add. Timing conflicts with another break.", $model->getConferenceId());
            }
        }

        $break = new LectureBreak(
            $model->getTitle(),
            $model->getDescription(),
            $model->getLectureId(),
            $model->getStartDate(),
            $model->getEndDate()
        );

        $this->dbContext->getLectureBreaksRepository()
            ->add($break);
        $this->dbContext->saveChanges();
        return new ServiceResponse(null, "Break added.", $model->getConferenceId());
    }

    public function addParticipant($lectureId, $participantId)
    {
        $lecture = $this->dbContext->getLecturesRepository()
            ->filterById(" = $lectureId")
            ->findOne();
        $user = $this->dbContext->getUsersRepository()
            ->filterById(" = $participantId")
            ->findOne();

        if ($lecture->getId() == null) {
            return new ServiceResponse(404, "Lecture not found.");
        }
        if ($user->getId() == null) {
            return new ServiceResponse(404, "User not found.");
        }

        $hallId = $lecture->getHall_Id();
        $hall = $this->dbContext->getHallsRepository()
            ->filterById(" = $hallId")
            ->findOne();
        $db = DatabaseData::getInstance(DatabaseConfig::DB_INSTANCE);
        $statement = $db->prepare($this::GET_LECTURE_PARTICIPANTS_COUNT);
        $statement->execute([$lectureId]);
        $participantsCount = $statement->fetch()['count'];
        $capacity = $hall->getCapacity();
        if ($capacity <= $participantsCount) {
            return new ServiceResponse(1, "No more places are available for this lecture.", $lecture->getConferenceId());
        }

        $isParticipatingStatement = $db->prepare($this::IS_USER_A_PARTICIPANT_IN_LECTURE);
        $isParticipatingStatement->execute([$participantId, $lectureId]);
        if ($isParticipatingStatement->rowCount() > 0) {
            return new ServiceResponse(409, "User is already a participant in this lecture.");
        }

        $participant = new LecturesParticipant($lectureId, $participantId);
        $this->dbContext->getLecturesParticipantsRepository()
            ->add($participant);
        $this->dbContext->saveChanges();
        return new ServiceResponse(null, "Successfuly joined lecture.", $lecture->getConferenceId());
    }

    public function deleteParticipant($lectureId, $participantId)
    {
        $lecture = $this->dbContext->getLecturesRepository()
            ->filterById(" = $lectureId")
            ->findOne();
        $user = $this->dbContext->getUsersRepository()
            ->filterById(" = $participantId")
            ->findOne();

        if ($lecture->getId() == null) {
            return new ServiceResponse(404, "Lecture not found.");
        }
        if ($user->getId() == null) {
            return new ServiceResponse(404, "User not found.");
        }

        $db = DatabaseData::getInstance(DatabaseConfig::DB_INSTANCE);
        $isParticipatingStatement = $db->prepare($this::IS_USER_A_PARTICIPANT_IN_LECTURE);
        $isParticipatingStatement->execute([$participantId, $lectureId]);
        if ($isParticipatingStatement->rowCount() == 0) {
            return new ServiceResponse(404, "User is not a participant in this lecture.");
        }

        $lectureParticipant = new LecturesParticipant($lectureId, $participantId);
        $this->dbContext->getLecturesParticipantsRepository()
            ->filterByLectureId(" = $lectureId")
            ->filterByParticipantId(" = $participantId")
            ->delete();
        return new ServiceResponse(null, "Participant removed from lecture.");
    }

    public function getHallsForLecture($lectureId)
    {
        $lecture = $this->dbContext->getLecturesRepository()
            ->filterById(" = $lectureId")
            ->findOne();
        if ($lecture->getId() == null) {
            return new ServiceResponse(404, 'Lecture not found.');
        }

        $conferenceId = $lecture->getConferenceId();
        $conference = $this->dbContext->getConferencesRepository()
            ->filterById(" = $conferenceId")
            ->findOne();
        $venueId = $conference->getVenue_Id();
        if ($venueId == null) {
            return new ServiceResponse(1, 'Conference venue must be selected first.');
        }
        $venueRequest = $this->dbContext->getVenueReservationRequestsRepository()
            ->filterByConferenceId(" = $conferenceId")
            ->filterByVenueId(" = $venueId")
            ->findOne();
        if ($venueRequest->getStatus() == 0) {
            return new ServiceResponse(1, 'Conference venue is not yet confirmed.');
        }

        $halls = $this->dbContext->getHallsRepository()
            ->filterByVenueId(" = $venueId")
            ->findAll();
        $models = [];
        foreach ($halls->getHalls() as $hall) {
            $model = new AddHallViewModel($hall);
            $model->setLectureId($lectureId);
            $model->setConferenceId($conferenceId);
            $models[] = $model;
        }

        return new ServiceResponse(null, null, $models);
    }

    const CHECK_HALL_AVAILABILITY = <<<TAG
select StartDate, EndDate
from lectures
where Hall_Id = ? and ((? >= StartDate and ? <= EndDate) or (? >= StartDate and ? <= EndDate))
TAG;

    const GET_LECTURE_PARTICIPANTS_COUNT = <<<TAG
select count(LectureId) as 'count'
from lecturesParticipants
where LectureId = ?
TAG;

    const IS_USER_A_PARTICIPANT_IN_LECTURE = <<<TAG
select LectureId
from lecturesParticipants
where ParticipantId = ? and LectureId = ?
TAG;
}