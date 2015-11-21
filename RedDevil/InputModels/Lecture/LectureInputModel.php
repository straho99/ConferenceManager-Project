<?php

namespace RedDevil\InputModels\Lecture;

use RedDevil\InputModels\BaseInputModel;
use RedDevil\Models\Lecture;

class LectureInputModel extends BaseInputModel {
    private $title;
    private $description;
    private $startDate;
    private $endDate;
    private $conferenceId;

    function __construct(Lecture $lecture)
    {
        $this->title = $lecture->getTitle();
        $this->description = $lecture->getDescription();
        $this->startDate = $lecture->getStartDate();
        $this->endDate = $lecture->getEndDate();
        $this->conferenceId = $lecture->getConferenceId();
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

    public function validate()
    {
        $this->validator->setRule('required', $this->title, null,
            'title | Title is required.');

        $this->validator->setRule('required', $this->startDate, null,
            'startDate | Start Date is required.');

        $this->validator->setRule('required', $this->endDate, null,
            'endDate | End Date is required.');

        $this->validator->setRule('required', $this->conferenceId, null,
            'conferenceId | ConferenceId is required.');

        $this->validator->setRule('minlength', $this->title, 3,
            'title | Title must be at least 3 characters long.');

        $this->validator->setRule('gt', new \DateTime(), $this->startDate,
            'startDate | Start Date must be a future date.');

        $this->validator->setRule('gt', new \DateTime(), $this->endDate,
            'endDate | End Date must be a future date.');

        parent::validate();
    }
}