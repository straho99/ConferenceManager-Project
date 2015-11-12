<?php

namespace RedDevil\Models;

class Todo
{
	const COL_ID = 'id';
	const COL_USER_ID = 'user_id';
	const COL_TEXT = 'text';

	private $id;
	private $user_id;
	private $text;

	public function __construct($user_id, $text, $id = null)
	{
		$this->setId($id);
		$this->setUser_id($user_id);
		$this->setText($text);
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
	public function getUser_id()
	{
		return $this->user_id;
	}

	/**
	* @param $user_id
	* @return $this
	*/
	public function setUser_id($user_id)
	{
		$this->user_id = $user_id;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getText()
	{
		return $this->text;
	}

	/**
	* @param $text
	* @return $this
	*/
	public function setText($text)
	{
		$this->text = $text;
		
		return $this;
	}

}