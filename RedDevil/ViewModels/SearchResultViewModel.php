<?php

namespace RedDevil\ViewModels;

public class SearchResultViewModel {
  private $results = [];
  
  public function addResult(ISearchResult $result) {
    $this->results[] = $result;
  }
  
  public function getResults() {
    return $this->results;
  }
}

?>
