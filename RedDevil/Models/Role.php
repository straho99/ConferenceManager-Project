<?php

namespace RedDevil\Models;

class Role
{
	const COL_ID = 'Id';
	const COL_NAME = 'Name';

	private $Id;
	private $Name;

	public function __construct($Id, $Name, $id = null)
	{
		$this->setId($Id);
		$this->setName($Name);
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

}