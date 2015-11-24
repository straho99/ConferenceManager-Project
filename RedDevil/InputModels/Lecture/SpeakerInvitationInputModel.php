<?php

namespace RedDevil\InputModels\Lecture;

use RedDevil\InputModels\BaseInputModel;

class SpeakerInvitationInputModel extends BaseInputModel {
    private $lectureId;
    private $speakerId;
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
    public function getSpeakerId()
    {
        return $this->speakerId;
    }

    /**
     * @param mixed $speakerId
     */
    public function setSpeakerId($speakerId)
    {
        $this->speakerId = $speakerId;
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
        $this->validator->setRule('required', $this->lectureId, null,
            'lectureId | LectureId is required.');

        $this->validator->setRule('required', $this->speakerId, null,
            'speakerId | SpeakerId is required.');

        $this->validator->setRule('required', $this->conferenceId, null,
            'conferenceId | ConferenceId is required.');


        parent::validate();
    }
}