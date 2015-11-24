<?php

namespace RedDevil\ViewModels;

class VenueRequestViewModel {
    private $venueId;
    private $conferenceId;
    private $venueTitle;

    function __construct($venueId, $conferenceId, $venueTitle)
    {
        $this->venueId = $venueId;
        $this->conferenceId = $conferenceId;
        $this->venueTitle = $venueTitle;
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
    public function getVenueTitle()
    {
        return $this->venueTitle;
    }

    /**
     * @param mixed $venueTitle
     */
    public function setVenueTitle($venueTitle)
    {
        $this->venueTitle = $venueTitle;
    }
}