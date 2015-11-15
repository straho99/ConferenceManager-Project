<?php

namespace RedDevil\Models;

class User
{
	const COL_ID = 'id';
	const COL_USERNAME = 'username';
	const COL_EMAIL = 'email';
	const COL_PASSWORD = 'password';
	const COL_FULLNAME = 'fullname';
	const COL_TELEPHONE = 'telephone';

	private $id;
	private $username;
	private $email;
	private $password;
	private $fullname;
	private $telephone;

	public function __construct($username, $email, $password, $fullname, $telephone, $id = null)
	{
		$this->setId($id);
		$this->setUsername($username);
		$this->setEmail($email);
		$this->setPassword($password);
		$this->setFullname($fullname);
		$this->setTelephone($telephone);
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
	public function getFullname()
	{
		return $this->fullname;
	}

	/**
	* @param $fullname
	* @return $this
	*/
	public function setFullname($fullname)
	{
		$this->fullname = $fullname;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getTelephone()
	{
		return $this->telephone;
	}

	/**
	* @param $telephone
	* @return $this
	*/
	public function setTelephone($telephone)
	{
		$this->telephone = $telephone;
		
		return $this;
	}

}