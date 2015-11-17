<?php

namespace RedDevil\InputModels\Venue;

use RedDevil\InputModels\BaseInputModel;

class HallInputModel extends BaseInputModel {
    private $title;
    private $capacity;
    private $venueId;

    function __construct()
    {
        parent::__construct();
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
    public function getCapacity()
    {
        return $this->capacity;
    }

    /**
     * @param mixed $capacity
     */
    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;
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

    public function validate()
    {
        $this->validator->setRule('required', $this->title, null,
            'title | Title is required.');

        $this->validator->setRule('required', $this->capacity, null,
            'capacity | Capacity is required.');

        $this->validator->setRule('gt', $this->capacity, 0,
            'capacity | Capacity must be a positive number.');

        parent::validate();
    }
}