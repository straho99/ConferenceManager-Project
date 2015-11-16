<?php

namespace RedDevil\Controllers;


use RedDevil\Core\HttpContext;
use RedDevil\InputModels\ExampleInputModel;
use RedDevil\Services\ConferencesService;
use RedDevil\View;

class HomeController extends BaseController {

    /**
     * @return \RedDevil\View
     * @Method('GET')
     */
    public function index()
    {
        $service = new ConferencesService($this->dbContext);
        $allConferences =$service->getAllConferences();

        return new View("home", "index", $allConferences);
    }
}