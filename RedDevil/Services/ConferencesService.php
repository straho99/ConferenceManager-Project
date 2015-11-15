<?php

namespace RedDevil\Services;

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
                ->getName();
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
}