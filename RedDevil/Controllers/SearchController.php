<?php
namespace RedDevil\Controllers;

public class SearchController extends BaseController {
	
	/**
	/* @Route('search/{string $keyword}')
	/**
	public function search($keyword) {
		$service = new SearchService($this->dbContext);
		$response = $service->search($keyword);
		$return new View('Search', 'results', $response->getModel());
	}
}
?>
