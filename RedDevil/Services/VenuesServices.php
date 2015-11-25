<?php

namespace RedDevil\Services;

use RedDevil\Config\DatabaseConfig;
use RedDevil\Core\DatabaseData;
use RedDevil\Core\HttpContext;
use RedDevil\InputModels\Venue\HallInputModel;
use RedDevil\InputModels\Venue\VenueInputModel;
use RedDevil\Models\Hall;
use RedDevil\Models\Venue;
use RedDevil\ViewModels\HallViewModel;
use RedDevil\ViewModels\OwnerVenueRequestViewModel;
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
    
    public function replyToVenueRequest($confirm, $requestId)
    {
        $request = $this->dbContext->getVenueReservationRequestsRepository()
            ->filterById(" = $requestId")
            ->findOne();

        $venueId = $request->getVenueId();
        $conferenceId = $request->getConferenceId();

        $venue = $this->dbContext->getVenuesRepository()
            ->filterById(" = $venueId")
            ->findOne();

        $conference = $this->dbContext->getConferencesRepository()
            ->filterById(" = $conferenceId")
            ->findOne();

        if ($venue->getId() == null) {
            return new ServiceResponse(404, "Venue not found.");
        }
        if ($conference->getId() == null) {
            return new ServiceResponse(404, "Conference not found.");
        }

        if ($request->getId() == null) {
            return new ServiceResponse(404, "Venue request not found.");
        }

        if (HttpContext::getInstance()->getIdentity()->getUserId() != $venue->getOwnerId()) {
            return new ServiceResponse(401, 'Replying to venue request only allowed for venue owner.');
        }

        $conferenceStartDate = $conference->getStartDate();
        $conferenceEndDate = $conference->getEndDate();

        $db = DatabaseData::getInstance(DatabaseConfig::DB_INSTANCE);
        $statement = $db->prepare($this::CHECK_VENUE_AVAILABILITY);

        $statement->execute(
            [$venueId, $conferenceStartDate, $conferenceStartDate, $conferenceEndDate, $conferenceEndDate]);
        if ($statement->rowCount() > 0) {
            $request->setStatus(2);
            $this->dbContext->saveChanges();
            return new ServiceResponse(1, "The venue is busy at this time. Request is denied.");
        }

        if ($confirm) {
            $request->setStatus(1);
            $conference->setVenue_Id(null);
            $this->dbContext->saveChanges();
            return new ServiceResponse(null, "Venue request was confirmed.");
        } else {
            $request->setStatus(2);
            $this->dbContext->saveChanges();
            return new ServiceResponse(null, "Venue request was rejected.");
        }
    }

    public function getVenueRequestsForUser()
    {
        $userId = HttpContext::getInstance()->getIdentity()->getUserId();
        $userVenues = $this->dbContext->getVenuesRepository()
            ->filterByOwnerId(" = $userId")
            ->findAll();
        $ids = [];
        foreach ($userVenues->getVenues() as $venue) {
            $ids[] = $venue->getId();
        }
        $inClause = '(' . implode(',', $ids) . ')';
        $userRequests = $this->dbContext->getVenueReservationRequestsRepository()
            ->filterByVenueId(" in $inClause")
            ->filterByStatus(" = 0")
            ->findAll();

        $requests = [];

        foreach ($userRequests->getVenueReservationRequests() as $request) {
            $venueId = $request->getVenueId();
            $model = new OwnerVenueRequestViewModel($request);

            $venue = $this->dbContext->getVenuesRepository()
                ->filterById(" = $venueId")
                ->findOne();
            $model->setVenueName($venue->getTitle());

            $conferenceId = $request->getConferenceId();
            $conference = $this->dbContext->getConferencesRepository()
                ->filterById(" = $conferenceId")
                ->findOne();
            $model->setConferenceId($conferenceId);
            $model->setConferenceTitle($conference->getTitle());
            $model->setStartDate($conference->getStartDate());
            $model->setEndDate($conference->getEndDate());

            $requests[] = $model;
        }

        return new ServiceResponse(null, null, $requests);
    }

    const CHECK_VENUE_AVAILABILITY = <<<TAG
select LectureId
from `lectures`
where venueId = ? and ((? >= StartDate and ? <= EndDate) or (? >= StartDate and ? <= EndDate))
TAG;

    const GET_USER_VENUE_REQUESTS = <<<TAG
select id
from venueReservationRequests
where VenueId in ?
TAG;
}