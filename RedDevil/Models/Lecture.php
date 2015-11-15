<?php

namespace RedDevil\Models;

class Lecture
{
	const COL_ID = 'Id';
	const COL_TITLE = 'Title';
	const COL_DESCRIPTION = 'Description';
	const COL_STARTDATE = 'StartDate';
	const COL_ENDDATE = 'EndDate';
	const COL_CONFERENCEID = 'ConferenceId';
	const COL_HALL_ID = 'Hall_Id';
	const COL_SPEAKER_ID = 'Speaker_Id';

	private $Id;
	private $Title;
	private $Description;
	private $StartDate;
	private $EndDate;
	private $ConferenceId;
	private $Hall_Id;
	private $Speaker_Id;

	public function __construct($Id, $Title, $Description, $StartDate, $EndDate, $ConferenceId, $Hall_Id, $Speaker_Id, $id = null)
	{
		$this->setId($Id);
		$this->setTitle($Title);
		$this->setDescription($Description);
		$this->setStartDate($StartDate);
		$this->setEndDate($EndDate);
		$this->setConferenceId($ConferenceId);
		$this->setHall_Id($Hall_Id);
		$this->setSpeaker_Id($Speaker_Id);
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
	public function getTitle()
	{
		return $this->Title;
	}

	/**
	* @param $Title
	* @return $this
	*/
	public function setTitle($Title)
	{
		$this->Title = $Title;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getDescription()
	{
		return $this->Description;
	}

	/**
	* @param $Description
	* @return $this
	*/
	public function setDescription($Description)
	{
		$this->Description = $Description;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getStartDate()
	{
		return $this->StartDate;
	}

	/**
	* @param $StartDate
	* @return $this
	*/
	public function setStartDate($StartDate)
	{
		$this->StartDate = $StartDate;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getEndDate()
	{
		return $this->EndDate;
	}

	/**
	* @param $EndDate
	* @return $this
	*/
	public function setEndDate($EndDate)
	{
		$this->EndDate = $EndDate;
		
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
	public function getHall_Id()
	{
		return $this->Hall_Id;
	}

	/**
	* @param $Hall_Id
	* @return $this
	*/
	public function setHall_Id($Hall_Id)
	{
		$this->Hall_Id = $Hall_Id;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getSpeaker_Id()
	{
		return $this->Speaker_Id;
	}

	/**
	* @param $Speaker_Id
	* @return $this
	*/
	public function setSpeaker_Id($Speaker_Id)
	{
		$this->Speaker_Id = $Speaker_Id;
		
		return $this;
	}

}