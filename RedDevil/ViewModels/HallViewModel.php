<?php

namespace RedDevil\ViewModels;

use RedDevil\Models\Hall;

class HallViewModel {
    private $id;
    private $title;
    private $capacity;

    function __construct(Hall $hall)
    {
        $this->id = $hall->getId();
        $this->title = $hall->getTitle();
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
}