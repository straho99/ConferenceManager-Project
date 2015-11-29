<?php

namespace RedDevil\Models;

class Lecturesparticipant
{
	const COL_ID = 'id';
	const COL_LECTUREID = 'LectureId';
	const COL_PARTICIPANTID = 'ParticipantId';

	private $id;
	private $LectureId;
	private $ParticipantId;

	public function __construct($LectureId, $ParticipantId, $id = null)
	{
		$this->setId($id);
		$this->setLectureId($LectureId);
		$this->setParticipantId($ParticipantId);
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
	public function getParticipantId()
	{
		return $this->ParticipantId;
	}

	/**
	* @param $ParticipantId
	* @return $this
	*/
	public function setParticipantId($ParticipantId)
	{
		$this->ParticipantId = $ParticipantId;
		
		return $this;
	}

}