<?php

namespace RedDevil\Models;

class Conference
{
	const COL_ID = 'id';
	const COL_TITLE = 'Title';
	const COL_STARTDATE = 'StartDate';
	const COL_ENDDATE = 'EndDate';
	const COL_OWNERID = 'OwnerId';
	const COL_VENUE_ID = 'Venue_Id';

	private $id;
	private $Title;
	private $StartDate;
	private $EndDate;
	private $OwnerId;
	private $Venue_Id;

	public function __construct($Title, $StartDate, $EndDate, $OwnerId, $Venue_Id, $id = null)
	{
		$this->setId($id);
		$this->setTitle($Title);
		$this->setStartDate($StartDate);
		$this->setEndDate($EndDate);
		$this->setOwnerId($OwnerId);
		$this->setVenue_Id($Venue_Id);
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
	public function getOwnerId()
	{
		return $this->OwnerId;
	}

	/**
	* @param $OwnerId
	* @return $this
	*/
	public function setOwnerId($OwnerId)
	{
		$this->OwnerId = $OwnerId;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getVenue_Id()
	{
		return $this->Venue_Id;
	}

	/**
	* @param $Venue_Id
	* @return $this
	*/
	public function setVenue_Id($Venue_Id)
	{
		$this->Venue_Id = $Venue_Id;
		
		return $this;
	}

}