<?php

namespace RedDevil\ViewModels;

use RedDevil\Models\VenueReservationRequest;

class OwnerVenueRequestViewModel {
    private $id;
    private $ownerId;
    private $venueId;
    private $venueName;
    private $conferenceId;
    private $conferenceTitle;
    private $startDate;
    private $endDate;

    function __construct(VenueReservationRequest $request)
    {
        $this->id = $request->getId();
        $this->venueId = $request->getVenueId();
        $this->conferenceId = $request->getConferenceId();
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
    public function getVenueName()
    {
        return $this->venueName;
    }

    /**
     * @param mixed $venueName
     */
    public function setVenueName($venueName)
    {
        $this->venueName = $venueName;
    }

    /**
     * @return mixed
     */
    public function getConferenceId()
    {
        return $this->conferenceId;
    }

    /**
     * @param mixed $conferenceId
     */
    public function setConferenceId($conferenceId)
    {
        $this->conferenceId = $conferenceId;
    }

    /**
     * @return mixed
     */
    public function getConferenceTitle()
    {
        return $this->conferenceTitle;
    }

    /**
     * @param mixed $conferenceTitle
     */
    public function setConferenceTitle($conferenceTitle)
    {
        $this->conferenceTitle = $conferenceTitle;
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
}