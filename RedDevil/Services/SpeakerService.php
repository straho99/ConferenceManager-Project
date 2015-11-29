<?php

namespace RedDevil\Services;

use RedDevil\Core\DatabaseData;

class SpeakerService extends BaseService {

    /**
     * @param bool $confirm
     * @param $lectureId
     * @param $speakerId
     * @return ServiceResponse
     */
    public function replyToSpeakerInvitation(bool $confirm, integer $lectureId, integer $speakerId) : ServiceResponse
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

        $lectureStartDate = $lecture->getStartDate();
        $lectureEndDate = $lecture->getEndDate();
        $db = DatabaseData::getInstance(DatabaseConfig::DB_INSTANCE);
        $statement = $db->prepare($this::CHECK_SPEAKER_AVAILABILITY);

        $statement->execute(
            [$speakerId, $lectureStartDate, $lectureStartDate, $lectureEndDate, $lectureEndDate]);
        if ($statement->rowCount() > 0) {
            return new ServiceResponse(1, "The hall is busy at this time. Request is denied.");
        }

        if ($confirm) {
            $invitation->setStatus(1);
            $this->dbContext->saveChanges();
            return new ServiceResponse(null, "Invitation was confirmed.");
        } else {
            $invitation->setStatus(2);
            $lecture->setSpeaker_Id(null);
            $this->dbContext->saveChanges();
            return new ServiceResponse(null, "Invitation was rejected.");
        }
    }

    const CHECK_SPEAKER_AVAILABILITY = <<<TAG
select StartDate, EndDate
from lectures
where Speaker_Id = ? and ((? >= StartDate and ? <= EndDate) or (? >= StartDate and ? <= EndDate))
TAG;
}