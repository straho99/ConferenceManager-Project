<?php

namespace RedDevil\Models;

class Message
{
	const COL_ID = 'id';
	const COL_SENDERID = 'SenderId';
	const COL_RECIPIENTID = 'RecipientId';
	const COL_CONTENT = 'Content';

	private $id;
	private $SenderId;
	private $RecipientId;
	private $Content;

	public function __construct($SenderId, $RecipientId, $Content, $id = null)
	{
		$this->setId($id);
		$this->setSenderId($SenderId);
		$this->setRecipientId($RecipientId);
		$this->setContent($Content);
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
	public function getSenderId()
	{
		return $this->SenderId;
	}

	/**
	* @param $SenderId
	* @return $this
	*/
	public function setSenderId($SenderId)
	{
		$this->SenderId = $SenderId;
		
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

}