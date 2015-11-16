<?php

namespace RedDevil\ViewModels;

use RedDevil\Models\Venue;

class VenueDetailsViewModel {
    private $id;
    private $name;
    private $description;
    private $address;
    private $ownerUsername;

    private $halls = [];

    function __construct(Venue $venue)
    {
        $this->id = $venue->getId();
        $this->name = $venue->getName();
        $this->address = $venue->getAddress();
        $this->description = $venue->getDescription();
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
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
    public function getHalls()
    {
        return $this->halls;
    }

    /**
     * @param array $halls
     */
    public function setHalls($halls)
    {
        $this->halls = $halls;
    }
}