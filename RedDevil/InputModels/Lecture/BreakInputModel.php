<?php

namespace RedDevil\InputModels\Lecture;

use RedDevil\InputModels\BaseInputModel;
use RedDevil\Models\LectureBreak;
use RedDevil\Services\IDateTimeInterval;

class BreakInputModel extends BaseInputModel implements IDateTimeInterval {
    private $title;
    private $description;
    private $startDate;
    private $endDate;
    private $lectureId;
    private $conferenceId;

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

        $this->validator->setRule('required', $this->lectureId, null,
            'conferenceId | ConferenceId is required.');

        $this->validator->setRule('minlength', $this->title, 3,
            'title | Title must be at least 3 characters long.');

        $this->validator->setRule('required', $this->startDate, null,
            'startDate | Start Date is required.');

        $this->validator->setRule('date', $this->startDate, null,
            'startDate | Start Date is not a valid date.');

        $this->validator->setRule('date', $this->endDate, null,
            'endDate | End Date is not a valid date.');

        $this->validator->setRule('required', $this->endDate, null,
            'endDate | End Date is required.');

        $this->validator->setRule('gt', new \DateTime(), $this->startDate,
            'startDate | Start Date must be a future date.');

        $this->validator->setRule('gt', new \DateTime(), $this->endDate,
            'endDate | End Date must be a future date.');

        parent::validate();
    }
}