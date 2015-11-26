<?php

namespace RedDevil\ViewModels;

use RedDevil\Models\SpeakerInvitation;
use RedDevil\Services\IDateTimeInterval;

class SpeakerInvitationViewModel implements IDateTimeInterval {
    private $id;
    private $speakerId;
    private $lectureId;
    private $conferenceId;
    private $lectureTitle;
    private $startDate;
    private $endDate;
    private $conferenceTitle;
    private $speakerUsername;

    function __construct(SpeakerInvitation $invitation)
    {
        $this->id = $invitation->getId();
        $this->speakerId = $invitation->getSpeakerId();
        $this->lectureId = $invitation->getLectureId();
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

    /**
     * @return mixed
     */
    public function getConferenceTitle()
    {
        return $this->conferenceTitle;
    }

    /**
     * @param mixed $conferenceTitle
     */
    public function setConferenceTitle($conferenceTitle)
    {
        $this->conferenceTitle = $conferenceTitle;
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
    public function getSpeakerUsername()
    {
        return $this->speakerUsername;
    }

    /**
     * @param mixed $speakerUsername
     */
    public function setSpeakerUsername($speakerUsername)
    {
        $this->speakerUsername = $speakerUsername;
    }
}