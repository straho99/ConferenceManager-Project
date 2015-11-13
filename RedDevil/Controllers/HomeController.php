<?php

namespace RedDevil\Controllers;


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