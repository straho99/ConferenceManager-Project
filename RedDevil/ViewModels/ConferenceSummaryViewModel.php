<?php

namespace RedDevil\ViewModels;

use RedDevil\Models\Conference;

class ConferenceSummaryViewModel {
    private $id;
    private $name;
    private $startDate;
    private $endDate;
    private $venue;
    private $venueId;
    private $ownerUsername;

    function __construct(Conference $conference)
    {
        $this->id = $conference->getId();
        $this->name = $conference->getName();
        $this->startDate = $conference->getStartDate();
        $this->endDate = $conference->getEndDate();
        $this->venueId = $conference->getVenue_Id();
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->startDate;
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
        return $this->endDate;
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
}