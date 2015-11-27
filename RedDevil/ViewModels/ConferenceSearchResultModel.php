<?php
public class ConferenceSearchResultModel implements ISearchResult { 
	private $id;
 
	private $title;
 
	private $ownerUsername;
 
	private $startDate;
 
	private $endDate;

	public function __construct(Conference $model) {
		$this->id = $model->getId();
		$this->title = $model->getTitle();
		$this->ownerUsername = $model->getOwnerUsername();
		$this->startDate = $model->getStartDate();
		$this->endDate = $model->getEndDate();
	}
	
	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function getTitle() {
		return $this->title;
	}

	public function setTitle($title) {
		$this->title= $title;
	}

	public function getOwnerUsername() {
		return $this->title;
	}

	public function setOwnerUsername($ownerUsername) {
		$this->ownerUsername = $ownerUsername;
	}

	public function getStartDate() {
		return $this->StartDate;
	}

	public function setStartDate($startDate) {
		$this->startDate= $startDate;
	}

	public function getResultText() 
	{ 
		return "Conference titled '$this->title', organised by $this->ownerUserName, starts on $this->startDate, ends on: $this-endDate.";
	}
 
	public function getResultUrl() 
	{ 
		return string.Format("/conferences/details/" . $this->Id);
	}       
} 
?>
