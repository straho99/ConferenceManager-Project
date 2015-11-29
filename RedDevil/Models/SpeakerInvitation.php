<?php

namespace RedDevil\Models;

class Speakerinvitation
{
	const COL_ID = 'id';
	const COL_LECTUREID = 'LectureId';
	const COL_SPEAKERID = 'SpeakerId';
	const COL_STATUS = 'Status';

	private $id;
	private $LectureId;
	private $SpeakerId;
	private $Status;

	public function __construct($LectureId, $SpeakerId, $Status, $id = null)
	{
		$this->setId($id);
		$this->setLectureId($LectureId);
		$this->setSpeakerId($SpeakerId);
		$this->setStatus($Status);
	}

	/**
	* @return mixed
	*/
	public function getId()
	{
		return $this->id;
	}

	/**
	* @param $id
	* @return $this
	*/
	public function setId($id)
	{
		$this->id = $id;
		
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