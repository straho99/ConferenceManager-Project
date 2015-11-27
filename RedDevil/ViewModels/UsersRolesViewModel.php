<?php

namespace RedDevil\ViewModels;

public class UsersRolesViewModel {
  private $username;
  private $fullName;
  private $roleTitles = [];
  
  public function getUsername() {
    return $this->username;
  }
  
  public function setUsername($username) {
    $this->username = $username;
  }
  
  public function getFullName() {
    return $this->fullName;
  }
  
  public function setFullName($fullName) {
    $this->fullName = $fullName;
  }
  
  public function getRoleTitles() {
    return $this->roleTitles;
  }
  
  public function setRoleTitles($roleTitles) {
    $this->roleTitles = $roleTitles;
  }
}
