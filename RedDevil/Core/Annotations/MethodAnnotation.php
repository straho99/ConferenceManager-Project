<?php

namespace RedDevil\Core\Annotations;

use RedDevil\Core\HttpContext;

class MethodAnnotation extends Annotation{
    private $methods = [];

    public function __construct($allowedMethods = [])
    {
        if (!is_array($allowedMethods)) {
            $this->methods[] = $allowedMethods;
        } else {
            $this->methods = $allowedMethods;
        }
    }

    public function onBeforeExecute()
    {
        $context = HttpContext::getInstance();
        $currentMethod = $context->getMethod();
        if (!in_array($currentMethod, $this->methods)) {
            throw new \Exception("Method not allowed", 405);
        }
    }

    public function onAfterExecute()
    {
        return;
    }
}