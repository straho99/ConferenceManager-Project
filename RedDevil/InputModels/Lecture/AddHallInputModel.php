<?php

namespace RedDevil\InputModels\Lecture;

use RedDevil\InputModels\BaseInputModel;

class AddHallInputModel extends BaseInputModel {
    private $lectureId;
    private $hallId;
    private $conferenceId;

    function __construct()
    {
        parent::__construct();
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
        $this->validator->setRule('required', $this->hallId, null,
            'hallId | HallId is required.');

        $this->validator->setRule('required', $this->lectureId, null,
            'lectureId | LectureId is required.');

        $this->validator->setRule('required', $this->conferenceId, null,
            'conferenceId | ConferenceId is required.');

        parent::validate();
    }
}