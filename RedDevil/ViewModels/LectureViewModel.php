<?php

namespace RedDevil\ViewModels;

use RedDevil\Models\Lecture;
use RedDevil\Services\IDateTimeInterval;

class LectureViewModel implements IDateTimeInterval {
    private $id;
    private $title;
    private $description;
    private $startDate;
    private $endDate;

    private $conferenceId;

    private $hallId;
    private $hallTitle;

    private $speakerId;
    private $speakerUsername;
    private $speakerRequestStatus;

    private $participantsCount;

    function __construct(Lecture $lecture)
    {
        $this->id = $lecture->getId();
        $this->title = $lecture->getTitle();
        $this->description = $lecture->getDescription();
        $this->startDate = $lecture->getStartDate();
        $this->endDate = $lecture->getEndDate();
        $this->conferenceId = $lecture->getConferenceId();
        $this->hallId = $lecture->getHall_Id();
        $this->speakerId = $lecture->getSpeaker_Id();
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
        $date = new \DateTime($this->startDate);
        return $date->format('d F Y H:i');
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
        $date = new \DateTime($this->endDate);
        return $date->format('d F Y H:i');
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

    /**
     * @return mixed
     */
    public function getParticipantsCount()
    {
        return $this->participantsCount;
    }

    /**
     * @param mixed $participantsCount
     */
    public function setParticipantsCount($participantsCount)
    {
        $this->participantsCount = $participantsCount;
    }

    /**
     * @return mixed
     */
    public function getSpeakerRequestStatus()
    {
        return $this->speakerRequestStatus;
    }

    /**
     * @param mixed $speakerRequestStatus
     */
    public function setSpeakerRequestStatus($speakerRequestStatus)
    {
        $this->speakerRequestStatus = $speakerRequestStatus;
    }
}