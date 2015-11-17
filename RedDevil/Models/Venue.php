<?php

namespace RedDevil\Models;

class Venue
{
	const COL_ID = 'id';
	const COL_NAME = 'Name';
	const COL_DESCRIPTION = 'Description';
	const COL_ADDRESS = 'Address';
	const COL_OWNERID = 'OwnerId';

	private $id;
	private $Name;
	private $Description;
	private $Address;
	private $OwnerId;

	public function __construct($Name, $Description, $Address, $OwnerId, $id = null)
	{
		$this->setId($id);
		$this->setName($Name);
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