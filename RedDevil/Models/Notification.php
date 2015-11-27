<?php

namespace RedDevil\Models;

class Notification
{
	const COL_ID = 'id';
	const COL_CONTENT = 'Content';
	const COL_USERID = 'UserId';
	const COL_ISREAD = 'IsRead';
	const COL_CREATEDON = 'CreatedOn';

	private $id;
	private $Content;
	private $UserId;
	private $IsRead;
	private $CreatedOn;

	public function __construct($Content, $UserId, $IsRead, $CreatedOn, $id = null)
	{
		$this->setId($id);
		$this->setContent($Content);
		$this->setUserId($UserId);
		$this->setIsRead($IsRead);
		$this->setCreatedOn($CreatedOn);
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
	public function getContent()
	{
		return $this->Content;
	}

	/**
	* @param $Content
	* @return $this
	*/
	public function setContent($Content)
	{
		$this->Content = $Content;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getUserId()
	{
		return $this->UserId;
	}

	/**
	* @param $UserId
	* @return $this
	*/
	public function setUserId($UserId)
	{
		$this->UserId = $UserId;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getIsRead()
	{
		return $this->IsRead;
	}

	/**
	* @param $IsRead
	* @return $this
	*/
	public function setIsRead($IsRead)
	{
		$this->IsRead = $IsRead;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getCreatedOn()
	{
		return $this->CreatedOn;
	}

	/**
	* @param $CreatedOn
	* @return $this
	*/
	public function setCreatedOn($CreatedOn)
	{
		$this->CreatedOn = $CreatedOn;
		
		return $this;
	}

}