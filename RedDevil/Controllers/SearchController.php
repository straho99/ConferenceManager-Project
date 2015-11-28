<?php
namespace RedDevil\Controllers;

use RedDevil\InputModels\Search\SearchInputModel;
use RedDevil\Services\SearchServices;
use RedDevil\View;

class SearchController extends BaseController {

    /**
     * @Validatetoken('token')
     * @Method('POST')
     * @param SearchInputModel $model
     * @return View
     */
	public function find(SearchInputModel $model) {
		$service = new SearchServices($this->dbContext);
		$response = $service->search($model->getKeyword());
        if (!$response->hasError()) {
            return new View('Search', 'result', $response->getModel());
        } else {
            $this->addErrorMessage($response->getMessage());
            $this->redirectToUrl('/home.index');
        }

	}
}