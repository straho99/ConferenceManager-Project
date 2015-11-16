<?php

namespace RedDevil\ViewModels;

use RedDevil\Models\Venue;

class VenueSummaryViewModel {
    private $id;
    private $name;
    private $address;
    private $ownerUsername;

    function __construct(Venue $venue)
    {
        $this->id = $venue->getId();
        $this->name = $venue->getName();
        $this->address = $venue->getAddress();
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
}