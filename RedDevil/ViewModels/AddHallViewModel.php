<?php

namespace RedDevil\ViewModels;

use RedDevil\Models\Hall;

class AddHallViewModel {
    private $conferenceId;
    private $lectureId;
    private $hallId;
    private $hallTitle;
    private $capacity;

    function __construct(Hall $hall)
    {
        $this->hallId = $hall->getId();
        $this->hallTitle = $hall->getTitle();
        $this->capacity = $hall->getCapacity();
    }

    /**
     * @return mixed
     */
    public function getLectureId()
    {
        return $this->lectureId;
    }

    /**
     * @param mixed $lectureId
     */
    public function setLectureId($lectureId)
    {
        $this->lectureId = $lectureId;
    }

    /**
     * @return mixed
     */
    public function getHallId()
    {
        return $this->hallId;
    }

    /**
     * @param mixed $hallId
     */
    public function setHallId($hallId)
    {
        $this->hallId = $hallId;
    }

    /**
     * @return mixed
     */
    public function getHallTitle()
    {
        return $this->hallTitle;
    }

    /**
     * @param mixed $hallTitle
     */
    public function setHallTitle($hallTitle)
    {
        $this->hallTitle = $hallTitle;
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
}