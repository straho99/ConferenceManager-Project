<?php

namespace RedDevil\InputModels\Conference;

use RedDevil\InputModels\BaseInputModel;

class ScheduleInputModel extends BaseInputModel {

    private $userId;
    private $lectureId;
    private $lectureTitle;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
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
    public function getLectureTitle()
    {
        return $this->lectureTitle;
    }

    /**
     * @param mixed $lectureTitle
     */
    public function setLectureTitle($lectureTitle)
    {
        $this->lectureTitle = $lectureTitle;
    }

    public function validate()
    {
        parent::validate();
    }
}