<?php

namespace RedDevil\Models;

class Hall
{
	const COL_ID = 'Id';
	const COL_NAME = 'Name';
	const COL_CAPACITY = 'Capacity';
	const COL_VENUEID = 'VenueId';

	private $Id;
	private $Name;
	private $Capacity;
	private $VenueId;

	public function __construct($Id, $Name, $Capacity, $VenueId, $id = null)
	{
		$this->setId($Id);
		$this->setName($Name);
		$this->setCapacity($Capacity);
		$this->setVenueId($VenueId);
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
	public function getCapacity()
	{
		return $this->Capacity;
	}

	/**
	* @param $Capacity
	* @return $this
	*/
	public function setCapacity($Capacity)
	{
		$this->Capacity = $Capacity;
		
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

}