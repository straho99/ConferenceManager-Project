<?php

namespace RedDevil\Services;

use RedDevil\Config\DatabaseConfig;
use RedDevil\Core\DatabaseData;
use RedDevil\Core\HttpContext;
use RedDevil\ViewModels\SpeakerInvitationViewModel;

class UsersServices extends BaseService {

    public function getSpeakerInvitationsForUser()
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

    public function replyToSpeakerInvitation($confirm, $invitationId)
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

    const CHECK_SPEAKER_AVAILABILITY = <<<TAG
select LectureId
from `lectures`
where Speaker_Id = ? and ((? >= StartDate and ? <= EndDate) or (? >= StartDate and ? <= EndDate))
TAG;
}