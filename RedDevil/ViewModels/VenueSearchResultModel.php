<?php
public class VenueSearchResultModel implements ISearchResult { 
	private $id;
 
	private $title
 
	private $owner;

	private $address;

	public function __construct(Venue $model) {
		$this->id = $model->getId();
		$this->title = $model->getTitle();
		$this->address = $model->getAddress();
	}
	
	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		return $this->id;
	}

	public function setTitle($title) {
		$this->title = $title;
	}

	public function getTitle() {
		return $this->title;
	}

	public function getAddress() {
		return $this-Address
	}

	public function setAddress($address) {
		$this->address = $address;
	}

	public function getResultText() 
	{ 
		return "Venue: $this->title, Owner: $this->owner, at address: $this->address.";
	}
 
	public function getResultUrl() 
	{ 
		return string.Format("/venues/details/" . $this->id);
	}       
} 
?>