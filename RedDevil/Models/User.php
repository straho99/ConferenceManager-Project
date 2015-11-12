<?php

namespace RedDevil\Models;

class User
{
	const COL_ID = 'id';
	const COL_USERNAME = 'username';
	const COL_PASSWORD = 'password';
	const COL_ROLE_ID = 'role_id';

	private $id;
	private $username;
	private $password;
	private $role_id;

	public function __construct($username, $password, $role_id, $id = null)
	{
		$this->setId($id);
		$this->setUsername($username);
		$this->setPassword($password);
		$this->setRole_id($role_id);
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
	public function getRole_id()
	{
		return $this->role_id;
	}

	/**
	* @param $role_id
	* @return $this
	*/
	public function setRole_id($role_id)
	{
		$this->role_id = $role_id;
		
		return $this;
	}

}