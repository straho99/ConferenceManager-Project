<?php

namespace RedDevil\Models;

class Lecturebreak
{
	const COL_ID = 'id';
	const COL_TITLE = 'Title';
	const COL_DESCRIPTION = 'Description';
	const COL_LECTUREID = 'LectureId';
	const COL_STARTDATE = 'StartDate';
	const COL_ENDDATE = 'EndDate';

	private $id;
	private $Title;
	private $Description;
	private $LectureId;
	private $StartDate;
	private $EndDate;

	public function __construct($Title, $Description, $LectureId, $StartDate, $EndDate, $id = null)
	{
		$this->setId($id);
		$this->setTitle($Title);
		$this->setDescription($Description);
		$this->setLectureId($LectureId);
		$this->setStartDate($StartDate);
		$this->setEndDate($EndDate);
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


	/**
	* @return mixed
	*/
	public function getStartDate()
	{
		return $this->StartDate;
	}

	/**
	* @param $StartDate
	* @return $this
	*/
	public function setStartDate($StartDate)
	{
		$this->StartDate = $StartDate;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getEndDate()
	{
		return $this->EndDate;
	}

	/**
	* @param $EndDate
	* @return $this
	*/
	public function setEndDate($EndDate)
	{
		$this->EndDate = $EndDate;
		
		return $this;
	}

}