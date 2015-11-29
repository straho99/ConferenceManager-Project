<?php

namespace RedDevil\Models;

class Venuereservationrequest
{
	const COL_ID = 'id';
	const COL_VENUEID = 'VenueId';
	const COL_CONFERENCEID = 'ConferenceId';
	const COL_STATUS = 'Status';

	private $id;
	private $VenueId;
	private $ConferenceId;
	private $Status;

	public function __construct($VenueId, $ConferenceId, $Status, $id = null)
	{
		$this->setId($id);
		$this->setVenueId($VenueId);
		$this->setConferenceId($ConferenceId);
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
	public function getVenueId()
	{
		return $this->VenueId;
	}

	/**
	* @param $VenueId
	* @return $this
	*/
	public function setVenueId($VenueId)
	{
		$this->VenueId = $VenueId;
		
		return $this;
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