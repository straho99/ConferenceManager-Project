<?php

namespace RedDevil\Models;

class Hall
{
	const COL_ID = 'id';
	const COL_NAME = 'Name';
	const COL_CAPACITY = 'Capacity';
	const COL_VENUEID = 'VenueId';

	private $id;
	private $Name;
	private $Capacity;
	private $VenueId;

	public function __construct($Name, $Capacity, $VenueId, $id = null)
	{
		$this->setId($id);
		$this->setName($Name);
		$this->setCapacity($Capacity);
		$this->setVenueId($VenueId);
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