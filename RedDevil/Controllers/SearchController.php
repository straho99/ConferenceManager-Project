<?php
namespace RedDevil\Controllers;

public class SearchController extends BaseController {
	
	/**
	* @Method('POST')
	*/
	public function find(SeearchInputModel $model) {
		$service = new SearchService($this->dbContext);
		$response = $service->search($model->getKeyword());
		$return new View('Search', 'results', $response->getModel());
	}
}
?>
