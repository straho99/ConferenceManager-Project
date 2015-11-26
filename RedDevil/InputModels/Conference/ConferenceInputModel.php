<?php

namespace RedDevil\InputModels\Conference;

use RedDevil\InputModels\BaseInputModel;
use RedDevil\Services\IDateTimeInterval;

class ConferenceInputModel extends BaseInputModel implements IDateTimeInterval {
    private $title;
    private $startDate;
    private $endDate;

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

    public function validate()
    {
        $this->validator->setRule('required', $this->title, null,
        'title | Title is required.');

        $this->validator->setRule('required', $this->startDate, null,
            'startDate | Start Date is required.');

        $this->validator->setRule('required', $this->endDate, null,
            'endDate | End Date is required.');

        $this->validator->setRule('minlength', $this->title, 3,
            'title | Title must be at least 3 characters long.');

        $this->validator->setRule('gt', new \DateTime(), $this->startDate,
            'startDate | Start Date must be a future date.');

        $this->validator->setRule('gt', new \DateTime(), $this->endDate,
            'endDate | End Date must be a future date.');

        parent::validate();
    }
}