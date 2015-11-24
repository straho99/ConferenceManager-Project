<?php

namespace RedDevil\Services;

class SpeakerService extends BaseService {

    /**
     * @param bool $confirm
     * @param $lectureId
     * @param $speakerId
     * @return ServiceResponse
     */
    public function replyToSpeakerInvitation($confirm, $lectureId, $speakerId)
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

        if ($confirm) {
            $invitation->setStatus(1);
            $this->dbContext->saveChanges();
            return new ServiceResponse(null, "Invitation was confirmed.");
        } else {
            $invitation->setStatus(2);
            $this->dbContext->saveChanges();
            return new ServiceResponse(null, "Invitation was rejected.");
        }
    }
}