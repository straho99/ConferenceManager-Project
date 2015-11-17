<?php

namespace RedDevil\Services;

use RedDevil\Core\HttpContext;
use RedDevil\InputModels\Conference\ConferenceInputModel;
use RedDevil\Models\Conference;
use RedDevil\ViewModels\ConferenceSummaryViewModel;

class ConferencesService extends BaseService {

    public function getAllConferences() {
        $conferenceModels = [];
        $conferences = $this->dbContext->getConferencesRepository()
            ->orderByDescending('StartDate')
            ->findAll();

        foreach ($conferences->getConferences() as $conference) {
            $conferenceId = $conference->getId();
            $venue = $this->dbContext->getVenuesRepository()
                ->filterById(" = $conferenceId")
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
}