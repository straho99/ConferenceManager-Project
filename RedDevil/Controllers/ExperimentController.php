<?php

namespace RedDevil\Controllers;

use RedDevil\EntityManager\DatabaseContext;
use RedDevil\Repositories\TodosRepository;
use RedDevil\Repositories\UsersRepository;
use RedDevil\View;
use RedDevil\ViewModels\SomeRandomViewModel;

class ExperimentController extends BaseController {

    public function index()
    {
        return new View('experiment', 'index');
    }

    public function ajax()
    {
        return new View('experiment', 'ajaxForm');
    }

    public function processAjaxRequest()
    {
        var_dump($_POST);
    }

    public function routes()
    {
        $model = new \RedDevil\ViewModels\SomeRandomViewModel();
//        $model = 12;
        return new View('experiment', 'routes', $model);
    }

    /**
     * @Method('GET')
     */
    public function displayalltodos()
    {
        $dbContext = new DatabaseContext(TodosRepository::create(), UsersRepository::create());
        $todos = $dbContext->getTodosRepository()->findAll();
        return new View('experiment', 'displayalltodos', $todos);
    }
}