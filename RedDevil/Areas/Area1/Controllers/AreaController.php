<?php

namespace RedDevil\Areas\Area1\Controllers;

use RedDevil\Areas\Area1\Models\BindingModels\TestBindingModel;
use RedDevil\View;

class AreaController {
    public function __construct()
    {

    }

    /**
     * @Route('annotationroute/{string username}/posts/{boolean logged}')
     */
    public function doSomething(\RedDevil\Areas\Area1\Models\BindingModels\TestBindingModel $model)
    {
        return new View('area', 'doSomething', $model , 'Default', 'Area1');
    }

    public function doSomethingElse()
    {
        return new View('area', 'doSomethingElse', null , 'Default', 'Area1');
    }
}