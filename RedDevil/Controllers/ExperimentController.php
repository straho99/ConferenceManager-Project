<?php

namespace RedDevil\Controllers;

use RedDevil\EntityManager\DatabaseContext;
use RedDevil\Repositories\RolesRepository;
use RedDevil\Repositories\TodosRepository;
use RedDevil\Repositories\UsersRepository;
use RedDevil\View;
use RedDevil\ViewModels\SomeRandomViewModel;

class ExperimentController extends BaseController {

    public function index()
    {
        return new View('Experiment', 'index');
    }

    public function ajax()
    {
        return new View('Experiment', 'ajaxForm');
    }

    public function processAjaxRequest()
    {
        var_dump($_POST);
    }

    public function routes()
    {
        $model = new \RedDevil\ViewModels\SomeRandomViewModel();
        return new View('Experiment', 'routes', $model);
    }

    /**
     * @Method('GET')
     */
    public function displayalltodos()
    {
        $todos = $this->dbContext->getTodosRepository()
            ->filterById(">= 7")
            ->filterById("<= 12")
            ->findAll();
        return new View('Experiment', 'displayalltodos', $todos, 'Default', null, true);
    }
}