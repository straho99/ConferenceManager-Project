<?php

namespace RedDevil\Core\Annotations;

class RouteAnnotation extends Annotation {

    private $route = '';

    public function __construct($routeValue)
    {
        $this->route = $routeValue;
    }

    public function onBeforeExecute()
    {
        return;
    }

    public function onAfterExecute()
    {
        return;
    }
}