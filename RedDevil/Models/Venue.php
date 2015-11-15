<?php

namespace RedDevil\Models;

class Venue
{
	const COL_ID = 'Id';
	const COL_NAME = 'Name';
	const COL_DESCRIPTION = 'Description';
	const COL_ADDRESS = 'Address';
	const COL_OWNERID = 'OwnerId';

	private $Id;
	private $Name;
	private $Description;
	private $Address;
	private $OwnerId;

	public function __construct($Id, $Name, $Description, $Address, $OwnerId, $id = null)
	{
		$this->setId($Id);
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