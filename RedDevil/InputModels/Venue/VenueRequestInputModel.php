<?php

namespace RedDevil\InputModels\Venue;

use RedDevil\InputModels\BaseInputModel;

class VenueRequestInputModel extends BaseInputModel {
    private $conferenceId;
    private $venueId;
    private $venues = [];

    function __construct()
    {
        parent::__construct();
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
    public function getVenues()
    {
        return $this->venues;
    }

    /**
     * @param mixed $venues
     */
    public function setVenues($venues)
    {
        $this->venues = $venues;
    }

    public function validate()
    {
        $this->validator->setRule('required', $this->conferenceId, null,
            'conferenceId | ConferenceId is required.');

        $this->validator->setRule('required', $this->venueId, null,
            'venueId | VenueId is required.');

        parent::validate();
    }
}