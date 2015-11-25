<?php

namespace RedDevil\Services;

use RedDevil\Config\DatabaseConfig;
use RedDevil\Core\DatabaseData;
use RedDevil\Core\HttpContext;
use RedDevil\InputModels\Lecture\BreakInputModel;
use RedDevil\InputModels\Lecture\LectureInputModel;
use RedDevil\InputModels\Lecture\SpeakerInvitationInputModel;
use RedDevil\Models\Lecture;
use RedDevil\Models\LectureBreak;
use RedDevil\Models\LecturesParticipant;
use RedDevil\Models\SpeakerInvitation;

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

        If(HttpContext::getInstance()->getIdentity()->getUserId() != $conference->getOwnerId()) {
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

    public function addHall($lectureId, $hallId)
    {
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

        $conferenceId = $lecture->getConferenceId();
        $conference = $this->dbContext->getConferencesRepository()
            ->filterById(" = $conferenceId")
            ->findOne();
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
            return new ServiceResponse(1, "The hall is busy at this time. Request is denied.");
        }

        $lecture->setHall_Id($hallId);
        $this->dbContext->saveChanges();
        return new ServiceResponse(null, "Hall added to lecture.");
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

    public function addBreak($lectureId, BreakInputModel $model)
    {
        $lecture = $this->dbContext->getLecturesRepository()
            ->filterById(" = $lectureId")
            ->findOne();

        if ($lecture->getId() == null) {
            return new ServiceResponse(404, "Lecture not found.");
        }

        $breakStart = strtotime($model->getStartDate());
        $breakEnd = strtotime($model->getEndDate());

        $lectureStart = strtotime($lecture->getStartDate());
        $lectureEnd = strtotime($lecture->getEndDate());

        if ($breakStart < $lectureStart || $breakStart > $lectureEnd) {
            return new ServiceResponse(1, "Break is outside of lecture time interval.");
        }

        if ($breakEnd < $lectureStart || $breakEnd > $lectureEnd) {
            return new ServiceResponse(1, "Break is outside of lecture time interval.");
        }

        $break = new LectureBreak(
            $model->getTitle(),
            $model->getDescription(),
            $lectureId,
            $model->getStartDate(),
            $model->getEndDate(),
            null
        );

        $this->dbContext->getLectureBreaksRepository()
            ->add($break);
        $this->dbContext->saveChanges();
        return new ServiceResponse(null, "Break added.");
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
            return new ServiceResponse(404, "No more places are available for this lecture.");
        }

        $isParticipatingStatement = $db->prepare($this::IS_USER_A_PARTICIPANT_IN_LECTURE);
        $isParticipatingStatement->execute([$participantId, $lectureId]);
        if ($isParticipatingStatement->rowCount() > 0) {
            return new ServiceResponse(404, "User is already a participant this lecture.");
        }

        $participant = new LecturesParticipant($lectureId, $participantId);
        $this->dbContext->getLecturesParticipantsRepository()
            ->add($participant);
        $this->dbContext->saveChanges();
        return new ServiceResponse(null, "Participant added.");
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