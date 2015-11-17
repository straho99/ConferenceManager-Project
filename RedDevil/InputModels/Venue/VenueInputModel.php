<?php

namespace RedDevil\InputModels\Venue;

use RedDevil\InputModels\BaseInputModel;

class VenueInputModel extends BaseInputModel {
    private $title;
    private $description;
    private $address;
    private $ownerId;

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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
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

    public function validate()
    {
        $this->validator->setRule('required', $this->title, null,
            'title | Title is required.');

        $this->validator->setRule('required', $this->description, null,
            'description | Description is required.');

        $this->validator->setRule('required', $this->address, null,
            'address | Address is required.');

        $this->validator->setRule('minlength', $this->title, 3,
            'title | Title must be at least 3 characters long.');

        $this->validator->setRule('minlength', $this->description, 3,
            'description | Description must be at least 3 characters long.');

        parent::validate();
    }
}