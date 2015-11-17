<?php

namespace RedDevil\Services;

use RedDevil\Core\HttpContext;
use RedDevil\InputModels\Venue\HallInputModel;
use RedDevil\InputModels\Venue\VenueInputModel;
use RedDevil\Models\Hall;
use RedDevil\Models\Venue;
use RedDevil\ViewModels\HallViewModel;
use RedDevil\ViewModels\VenueDetailsViewModel;
use RedDevil\ViewModels\VenueSummaryViewModel;

class VenuesServices extends BaseService {

    public function getAllVenues()
    {
        $venueModels = [];
        $venues = $this->dbContext->getVenuesRepository()
            ->orderByDescending('Title')
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

    /**
     * @param $venueId
     * @return VenueDetailsViewModel
     */
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

    /**
     * @param VenueInputModel $model
     * @return ServiceResponse
     * @throws \Exception
     */
    public function addVenue(VenueInputModel $model)
    {
        $venue = new Venue(
            $model->getTitle(),
            $model->getDescription(),
            $model->getAddress(),
            HttpContext::getInstance()->getIdentity()->getUserId()
        );
        $this->dbContext->getVenuesRepository()
            ->add($venue);
        $this->dbContext->saveChanges();
        return new ServiceResponse(null, 'Venue added successfully.');
    }

    public function addHall(HallInputModel $model)
    {
        $hall = new Hall(
            $model->getTitle(),
            $model->getCapacity(),
            $model->getVenueId()
        );
        $this->dbContext->getHallsRepository()
            ->add($hall);
        $this->dbContext->saveChanges();
        return new ServiceResponse(null, 'Hall added successfully.');
    }

    public function deleteHall($hallId)
    {
        $hall = $this->dbContext->getHallsRepository()
            ->filterById(" = $hallId")
            ->delete();

        $this->dbContext->saveChanges();
        return new ServiceResponse(null, 'Hall deleted successfully.');
    }
}