<?php

namespace RedDevil\Services;

use RedDevil\Config\AppConfig;
use RedDevil\Config\DatabaseConfig;
use RedDevil\Core\DatabaseData;
use RedDevil\Core\HttpContext;
use RedDevil\InputModels\Conference\ConferenceInputModel;
use RedDevil\Models\Conference;
use RedDevil\ViewModels\ConferenceSummaryViewModel;
use RedDevil\ViewModels\LectureViewModel;

class ConferencesService extends BaseService {

    public function getAllConferences() {
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
    public function addConference(ConferenceInputModel $model)
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
        return new ServiceResponse(null, 'Conference added successfully.');
    }

    public function getConferenceDetails($conferenceId)
    {
        $db = DatabaseData::getInstance(DatabaseConfig::DB_INSTANCE);
        $statement = $db->prepare("select count(LectureId) from lecturesParticipants where LectureId = ?");

        $conference = $this->dbContext->getConferencesRepository()
            ->filterById(" = $conferenceId")
            ->findOne();

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
        $model->setVenueId($venueId);
        $model->setVenue($venue);
        $model->setOwnerUsername($owner);

        $lectures = $this->dbContext->getLecturesRepository()
            ->filterByConferenceId("")
            ->findOne(" = $conferenceId");
        $lecturesModels = [];
        foreach ($lectures as $lecture) {
            $lectureModel = new LectureViewModel($lecture);
            $hallId = $lectureModel->getHallId();
            $hall = $this->dbContext->getHallsRepository()
                ->filterById(" = $hallId")
                ->findOne();
            $lectureModel->setHallTitle($hall->getTitle());

            $speakerId = $lectureModel->getSpeakerId();
            $speaker = $this->dbContext->getUsersRepository()
                ->filterById(" = $speakerId")
                ->findOne();
            $lectureModel->setSpeakerUsername($speaker->getUsername());

            $lectureId = $lectureModel->getId();
            $participants = $statement->fetch([$lectureId]);
            $lectureModel->setParticipantsCount($participants);

            $lecturesModels[] = $lectureModel;
        }

        return $lecturesModels;
    }
}