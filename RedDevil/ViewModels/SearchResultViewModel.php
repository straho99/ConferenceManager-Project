<?php

namespace RedDevil\ViewModels;

class SearchResultViewModel {
  private $results = [];
  
  public function addResult($result) {
    $this->results[] = $result;
  }
  
  public function getResults() {
    return $this->results;
  }
}
