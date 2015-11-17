<?php

namespace RedDevil\Models;

class Venue
{
	const COL_ID = 'id';
	const COL_TITLE = 'Title';
	const COL_DESCRIPTION = 'Description';
	const COL_ADDRESS = 'Address';
	const COL_OWNERID = 'OwnerId';

	private $id;
	private $Title;
	private $Description;
	private $Address;
	private $OwnerId;

	public function __construct($Title, $Description, $Address, $OwnerId, $id = null)
	{
		$this->setId($id);
		$this->setTitle($Title);
		$this->setDescription($Description);
		$this->setAddress($Address);
		$this->setOwnerId($OwnerId);
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
	public function getAddress()
	{
		return $this->Address;
	}

	/**
	* @param $Address
	* @return $this
	*/
	public function setAddress($Address)
	{
		$this->Address = $Address;
		
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

}