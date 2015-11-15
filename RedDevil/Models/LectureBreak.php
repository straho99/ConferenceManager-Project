<?php

namespace RedDevil\Models;

class LectureBreak
{
	const COL_ID = 'Id';
	const COL_TITLE = 'Title';
	const COL_DESCRIPTION = 'Description';
	const COL_LECTUREID = 'LectureId';

	private $Id;
	private $Title;
	private $Description;
	private $LectureId;

	public function __construct($Id, $Title, $Description, $LectureId, $id = null)
	{
		$this->setId($Id);
		$this->setTitle($Title);
		$this->setDescription($Description);
		$this->setLectureId($LectureId);
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
	public function getTitle()
	{
		return $this->Title;
	}

	/**
	* @param $Title
	* @return $this
	*/
	public function setTitle($Title)
	{
		$this->Title = $Title;
		
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
	public function getLectureId()
	{
		return $this->LectureId;
	}

	/**
	* @param $LectureId
	* @return $this
	*/
	public function setLectureId($LectureId)
	{
		$this->LectureId = $LectureId;
		
		return $this;
	}

}