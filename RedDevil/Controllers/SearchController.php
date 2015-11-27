<?php
namespace RedDevil\Controllers;

use RedDevil\InputModels\Search\SearchInputModel;
use RedDevil\Services\SearchServices;
use RedDevil\View;

class SearchController extends BaseController {
	
	/**
	* @Method('POST')
	*/
	public function find(SearchInputModel $model) {
		$service = new SearchServices($this->dbContext);
		$response = $service->search($model->getKeyword());
		return new View('Search', 'results', $response->getModel());
	}
}
?>
