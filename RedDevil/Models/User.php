<?php

namespace RedDevil\Models;

class User
{
	const COL_ID = 'id';
	const COL_USERNAME = 'username';
	const COL_PASSWORD = 'password';
	const COL_EMAIL = 'email';

	private $id;
	private $username;
	private $password;
	private $email;

	public function __construct($username, $password, $email, $id = null)
	{
		$this->setId($id);
		$this->setUsername($username);
		$this->setPassword($password);
		$this->setEmail($email);
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
	public function getUsername()
	{
		return $this->username;
	}

	/**
	* @param $username
	* @return $this
	*/
	public function setUsername($username)
	{
		$this->username = $username;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getPassword()
	{
		return $this->password;
	}

	/**
	* @param $password
	* @return $this
	*/
	public function setPassword($password)
	{
		$this->password = $password;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getEmail()
	{
		return $this->email;
	}

	/**
	* @param $email
	* @return $this
	*/
	public function setEmail($email)
	{
		$this->email = $email;
		
		return $this;
	}

}