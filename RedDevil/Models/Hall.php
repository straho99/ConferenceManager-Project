<?php

namespace RedDevil\Models;

class Hall
{
	const COL_ID = 'id';
	const COL_TITLE = 'Title';
	const COL_CAPACITY = 'Capacity';
	const COL_VENUEID = 'VenueId';

	private $id;
	private $Title;
	private $Capacity;
	private $VenueId;

	public function __construct($Title, $Capacity, $VenueId, $id = null)
	{
		$this->setId($id);
		$this->setTitle($Title);
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