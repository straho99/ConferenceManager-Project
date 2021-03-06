<?php

namespace RedDevil\ViewModels;

use RedDevil\Models\Conference;
use RedDevil\Services\IDateTimeInterval;

class ConferenceDetailsViewModel implements IDateTimeInterval {
    private $id;
    private $title;
    private $startDate;
    private $endDate;
    private $venue;
    private $venueId;
    private $venueRequestStatus;
    private $ownerId;
    private $ownerUsername;

    private $lectures = [];

    function __construct(Conference $conference)
    {
        $this->id = $conference->getId();
        $this->title = $conference->getTitle();
        $this->startDate = $conference->getStartDate();
        $this->endDate = $conference->getEndDate();
        $this->venueId = $conference->getVenue_Id();
        $this->ownerId = $conference->getOwnerId();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        $date = new \DateTime($this->startDate);
        return $date->format('d F Y');
    }

    /**
     * @param mixed $startDate
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        $date = new \DateTime($this->endDate);
        return $date->format('d F Y');
    }

    /**
     * @param mixed $endDate
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }

    /**
     * @return mixed
     */
    public function getVenue()
    {
        return $this->venue;
    }

    /**
     * @param mixed $venue
     */
    public function setVenue($venue)
    {
        $this->venue = $venue;
    }

    /**
     * @return mixed
     */
    public function getVenueId()
    {
        return $this->venueId;
    }

    /**
     * @param mixed $venueId
     */
    public function setVenueId($venueId)
    {
        $this->venueId = $venueId;
    }

    /**
     * @return mixed
     */
    public function getOwnerUsername()
    {
        return $this->ownerUsername;
    }

    /**
     * @param mixed $ownerUsername
     */
    public function setOwnerUsername($ownerUsername)
    {
        $this->ownerUsername = $ownerUsername;
    }

    /**
     * @return array
     */
    public function getLectures()
    {
        return $this->lectures;
    }

    /**
     * @param array $lectures
     */
    public function setLectures($lectures)
    {
        $this->lectures = $lectures;
    }

    /**
     * @return mixed
     */
    public function getOwnerId()
    {
        return $this->ownerId;
    }

    /**
     * @param mixed $ownerId
     */
    public function setOwnerId($ownerId)
    {
        $this->ownerId = $ownerId;
    }

    /**
     * @return mixed
     */
    public function getVenueRequestStatus()
    {
        return $this->venueRequestStatus;
    }

    /**
     * @param mixed $venueRequestStatus
     */
    public function setVenueRequestStatus($venueRequestStatus)
    {
        $this->venueRequestStatus = $venueRequestStatus;
    }
}