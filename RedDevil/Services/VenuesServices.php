<?php

namespace RedDevil\Services;

use RedDevil\ViewModels\HallViewModel;
use RedDevil\ViewModels\VenueDetailsViewModel;
use RedDevil\ViewModels\VenueSummaryViewModel;

class VenuesServices extends BaseService {

    public function getAllVenues()
    {
        $venueModels = [];
        $venues = $this->dbContext->getVenuesRepository()
            ->orderByDescending('Name')
            ->findAll();
        foreach ($venues->getVenues() as $venue) {
            $model = new VenueSummaryViewModel($venue);
            $venueModels[] = $model;
            $ownerId = $venue->getOwnerId();
            $owner = $this->dbContext->getUsersRepository()
                ->filterById(" = $ownerId")
                ->findOne()
                ->getUsername();
            $model->setOwnerUsername($owner);
        }
        return $venueModels;
    }

    public function getVenueDetails($venueId)
    {
        $venue = $this->dbContext->getVenuesRepository()
            ->filterById(" = $venueId")
            ->findOne();

        $ownerId = $venue->getOwnerId();
        $owner = $this->dbContext->getUsersRepository()
            ->filterById(" = $ownerId")
            ->findOne()
            ->getUsername();

        $model = new VenueDetailsViewModel($venue);
        $model->setOwnerUsername($owner);

        $halls = $this->dbContext->getHallsRepository()
            ->filterByVenueId(" = $venueId")
            ->findAll();
        $hallModels = [];
        foreach ($halls->getHalls() as $hall) {
            $hallModel = new HallViewModel($hall);
            $hallModels[] = $hallModel;
        }
        $model->setHalls($hallModels);

        return $model;
    }
}