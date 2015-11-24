<?php

namespace RedDevil\ViewModels;

class SpeakerInvitationViewModel {
    private $speakerId;
    private $lectureId;
    private $conferenceId;
    private $speakerUserName;

    function __construct($speakerId, $lectureId, $conferenceId, $speakerUserName)
    {
        $this->speakerId = $speakerId;
        $this->lectureId = $lectureId;
        $this->speakerUserName = $speakerUserName;
        $this->conferenceId = $conferenceId;
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
    public function getSpeakerUserName()
    {
        return $this->speakerUserName;
    }

    /**
     * @param mixed $speakerUserName
     */
    public function setSpeakerUserName($speakerUserName)
    {
        $this->speakerUserName = $speakerUserName;
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