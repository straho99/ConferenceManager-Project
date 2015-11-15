<?php

namespace RedDevil\Models;

class Conference
{
	const COL_ID = 'Id';
	const COL_NAME = 'Name';
	const COL_STARTDATE = 'StartDate';
	const COL_ENDDATE = 'EndDate';
	const COL_OWNERID = 'OwnerId';
	const COL_VENUE_ID = 'Venue_Id';

	private $Id;
	private $Name;
	private $StartDate;
	private $EndDate;
	private $OwnerId;
	private $Venue_Id;

	public function __construct($Id, $Name, $StartDate, $EndDate, $OwnerId, $Venue_Id, $id = null)
	{
		$this->setId($Id);
		$this->setName($Name);
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
	public function getName()
	{
		return $this->Name;
	}

	/**
	* @param $Name
	* @return $this
	*/
	public function setName($Name)
	{
		$this->Name = $Name;
		
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