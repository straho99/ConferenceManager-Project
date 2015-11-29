<?php

namespace RedDevil\Models;

class Conferencesparticipant
{
	const COL_CONFERENCEID = 'ConferenceId';
	const COL_PARTICIPANTID = 'ParticipantId';

	private $ConferenceId;
	private $ParticipantId;

	public function __construct($ConferenceId, $ParticipantId, $id = null)
	{
		$this->setConferenceId($ConferenceId);
		$this->setParticipantId($ParticipantId);
	}

	/**
	* @return mixed
	*/
	public function getConferenceId()
	{
		return $this->ConferenceId;
	}

	/**
	* @param $ConferenceId
	* @return $this
	*/
	public function setConferenceId($ConferenceId)
	{
		$this->ConferenceId = $ConferenceId;
		
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