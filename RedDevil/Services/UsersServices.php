<?php

namespace RedDevil\Services;

use RedDevil\Config\DatabaseConfig;
use RedDevil\Core\DatabaseData;
use RedDevil\Core\HttpContext;
use RedDevil\ViewModels\LectureViewModel;
use RedDevil\ViewModels\SpeakerInvitationViewModel;

class UsersServices extends BaseService {

    public function getSpeakerInvitationsForUser() : ServiceResponse
    {
        $userId = HttpContext::getInstance()->getIdentity()->getUserId();
        $invitations = $this->dbContext->getSpeakerInvitationsRepository()
            ->filterBySpeakerId(" = $userId")
            ->filterByStatus(" = 0")
            ->findAll();

        $models = [];
        foreach ($invitations->getSpeakerInvitations() as $invitation) {
            $model = new SpeakerInvitationViewModel($invitation);

            $lectureId = $invitation->getLectureId();
            $lecture = $this->dbContext->getLecturesRepository()
                ->filterById(" = $lectureId")
                ->findOne();
            $model->setLectureTitle($lecture->getTitle());
            $model->setStartDate($lecture->getStartDate());
            $model->setEndDate($lecture->getEndDate());

            $conferenceId = $lecture->getConferenceId();
            $conference = $this->dbContext->getConferencesRepository()
                ->filterById(" = $conferenceId")
                ->findOne();
            $model->setConferenceTitle($conference->getTitle());
            $model->setConferenceId($conferenceId);

            $models[] = $model;
        }

        return new ServiceResponse(null, null, $models);
    }

    public function replyToSpeakerInvitation(bool $confirm, integer $invitationId) : ServiceResponse
    {
        $invitation = $this->dbContext->getSpeakerInvitationsRepository()
            ->filterById(" = $invitationId")
            ->findOne();

        $lectureId = $invitation->getLectureId();
        $speakerId = $invitation->getSpeakerId();

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

        if ($invitation->getId() == null) {
            return new ServiceResponse(404, "Speaker invitation not found.");
        }

        if (HttpContext::getInstance()->getIdentity()->getUserId() != $speakerId) {
            return new ServiceResponse(401, 'Unauthorised. You must be recipient of the invitation.');
        }

        $lectureStartDate = $lecture->getStartDate();
        $lectureEndDate = $lecture->getEndDate();

        $db = DatabaseData::getInstance(DatabaseConfig::DB_INSTANCE);
        $statement = $db->prepare($this::CHECK_SPEAKER_AVAILABILITY);

        $statement->execute(
            [$speakerId, $lectureStartDate, $lectureStartDate, $lectureEndDate, $lectureEndDate]);
        if ($statement->rowCount() > 0) {
            $invitation->setStatus(2);
            $lecture->setSpeaker_Id(null);
            $this->dbContext->saveChanges();
            return new ServiceResponse(1, "The venue is busy at this time. Request is rejected.");
        }

        if ($confirm) {
            $invitation->setStatus(1);
            $this->dbContext->saveChanges();
            return new ServiceResponse(null, "Speaker invitation was confirmed.");
        } else {
            $invitation->setStatus(2);
            $lecture->setSpeaker_Id(null);
            $this->dbContext->saveChanges();
            return new ServiceResponse(null, "Speaker invitation was rejected.");
        }
    }
    
    public function getUsersSchedule() : ServiceResponse
    {
        $userId = HttpContext::getInstance()->getIdentity()->getUserId();
        if ($userId == null) {
            return new ServiceResponse(401, 'Unauthorised. Only logged users can get their schedule.');
        }

        $participations = $this->dbContext->getLecturesParticipantsRepository()
            ->filterByParticipantId(" = $userId")
            ->findAll();

        $lectureIds = [];
        foreach ($participations->getLecturesParticipants() as $participation) {
            $lectureIds[] = $participation->getLectureId();
        }
        $inList = "(" . implode(',', $lectureIds) . ")";

        $todayDate = new \DateTime('now');
        $today = $todayDate->format('Y-m-d H:i:s');
        $lectures = $this->dbContext->getLecturesRepository()
            ->orderBy("StartDate")
            ->filterById(" in $inList")
            ->filterByStartDate(" >= '$today'")
            ->findAll();

        $lecturesModels = [];
        $db = DatabaseData::getInstance(DatabaseConfig::DB_INSTANCE);

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
            }

            $lecturesModels[] = $lectureModel;
        }

        return new ServiceResponse(null, null, $lecturesModels);
    }

    public function getSpeakerSchedule() : ServiceResponse
    {
        $userId = HttpContext::getInstance()->getIdentity()->getUserId();
        if ($userId == null) {
            return new ServiceResponse(401, "Unauthorised. Only logged users can get their speaker's schedule.");
        }

        $todayDate = new \DateTime('now');
        $today = $todayDate->format('Y-m-d H:i:s');
        $lectures = $this->dbContext->getLecturesRepository()
            ->orderBy("StartDate")
            ->filterBySpeaker_Id(" = $userId")
            ->filterByStartDate(" >= '$today'")
            ->findAll();

        $lecturesModels = [];
        $db = DatabaseData::getInstance(DatabaseConfig::DB_INSTANCE);

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
            }

            $lecturesModels[] = $lectureModel;
        }

        return new ServiceResponse(null, null, $lecturesModels);
    }

    const CHECK_SPEAKER_AVAILABILITY = <<<TAG
select LectureId
from `lectures`
where Speaker_Id = ? and ((? >= StartDate and ? <= EndDate) or (? >= StartDate and ? <= EndDate))
TAG;
}