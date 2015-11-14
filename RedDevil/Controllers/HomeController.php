<?php

namespace RedDevil\Controllers;


use RedDevil\Core\HttpContext;
use RedDevil\InputModels\ExampleInputModel;
use RedDevil\View;

class HomeController extends BaseController {

    /**
     * @return \RedDevil\View
     * @Method('GET')
     */
    public function index()
    {
        return new View("home", "index");
    }
}