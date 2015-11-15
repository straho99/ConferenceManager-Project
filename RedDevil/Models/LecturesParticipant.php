<?php

namespace RedDevil\Models;

class LecturesParticipant
{
	const COL_LECTUREID = 'LectureId';
	const COL_PARTICIPANTID = 'ParticipantId';

	private $LectureId;
	private $ParticipantId;

	public function __construct($LectureId, $ParticipantId, $id = null)
	{
		$this->setLectureId($LectureId);
		$this->setParticipantId($ParticipantId);
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