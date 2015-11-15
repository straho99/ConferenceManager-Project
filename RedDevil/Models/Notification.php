<?php

namespace RedDevil\Models;

class Notification
{
	const COL_ID = 'Id';
	const COL_CONTENT = 'Content';
	const COL_ISREAD = 'IsRead';
	const COL_RECIPIENTID = 'RecipientId';

	private $Id;
	private $Content;
	private $IsRead;
	private $RecipientId;

	public function __construct($Id, $Content, $IsRead, $RecipientId, $id = null)
	{
		$this->setId($Id);
		$this->setContent($Content);
		$this->setIsRead($IsRead);
		$this->setRecipientId($RecipientId);
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
	public function getRecipientId()
	{
		return $this->RecipientId;
	}

	/**
	* @param $RecipientId
	* @return $this
	*/
	public function setRecipientId($RecipientId)
	{
		$this->RecipientId = $RecipientId;
		
		return $this;
	}

}