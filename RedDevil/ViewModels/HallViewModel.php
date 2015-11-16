<?php

namespace RedDevil\ViewModels;

use RedDevil\Models\Hall;

class HallViewModel {
    private $id;
    private $name;
    private $capacity;

    function __construct(Hall $hall)
    {
        $this->id = $hall->getId();
        $this->name = $hall->getName();
        $this->capacity = $hall->getCapacity();
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
}