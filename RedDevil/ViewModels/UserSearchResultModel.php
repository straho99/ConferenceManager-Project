<?php
public class UserSearchResultModel implements ISearchResult { 
	private $id;
 
	private $fullName;
 
	private $username;

	public function __construct(User $model) {
		$this->id = $model->getId();
		$this->fullName = $model->getFullName();
		$this->username = $model->username();
	}
	
	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		return $this->id;
	}

	public function setFullName($fullName) {
		$this->fullName = $fullName;
	}

	public function getFullName() {
		return $this->fullName;
	}

	public function getUsername() {
		return $this->username;
	}

	public function setUsername($username) {
		$this->username = $username;
	}

	public function getResultText() 
	{ 
		return "Username: $this->username; Full name: $this->fullName.";
	}
 
	public function getResultUrl() 
	{ 
		return string.Format("/users/" . $this->username . '/info');
	}       
} 
?>