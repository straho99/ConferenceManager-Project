<?php

namespace RedDevil\Models;

class SpeakerInvitation
{
	const COL_ID = 'Id';
	const COL_LECTUREID = 'LectureId';
	const COL_SPEAKERID = 'SpeakerId';
	const COL_STATUS = 'Status';

	private $Id;
	private $LectureId;
	private $SpeakerId;
	private $Status;

	public function __construct($Id, $LectureId, $SpeakerId, $Status, $id = null)
	{
		$this->setId($Id);
		$this->setLectureId($LectureId);
		$this->setSpeakerId($SpeakerId);
		$this->setStatus($Status);
	}

	/**
	* @return mixed
	*/
	public function getId()
	{
		return $this->Id;
	}

	/**
	* @param $Id
	* @return $this
	*/
	public function setId($Id)
	{
		$this->Id = $Id;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getLectureId()
	{
		return $this->LectureId;
	}

	/**
	* @param $LectureId
	* @return $this
	*/
	public function setLectureId($LectureId)
	{
		$this->LectureId = $LectureId;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getSpeakerId()
	{
		return $this->SpeakerId;
	}

	/**
	* @param $SpeakerId
	* @return $this
	*/
	public function setSpeakerId($SpeakerId)
	{
		$this->SpeakerId = $SpeakerId;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getStatus()
	{
		return $this->Status;
	}

	/**
	* @param $Status
	* @return $this
	*/
	public function setStatus($Status)
	{
		$this->Status = $Status;
		
		return $this;
	}

}