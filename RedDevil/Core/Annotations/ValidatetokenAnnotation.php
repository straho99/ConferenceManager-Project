<?php

namespace RedDevil\Core\Annotations;

use RedDevil\Core\HttpContext;

class ValidatetokenAnnotation extends Annotation {

    public function __construct($dummy)
    {
    }

    public function onBeforeExecute()
    {
        $context = HttpContext::getInstance();

        if (!$context->isPost()) {
            return;
        }

        if (!$context->session('ValidationToken')) {
            throw new \Exception("Unauthorized", 401);
        }
    }

    public function onAfterExecute()
    {
        return;
    }
}