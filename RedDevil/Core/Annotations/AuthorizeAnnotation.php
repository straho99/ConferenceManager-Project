<?php

namespace RedDevil\Core\Annotations;

use RedDevil\Core\HttpContext;

class AuthorizeAnnotation extends  Annotation {

    public function onBeforeExecute()
    {
        $context = HttpContext::getInstance();
        if (!$context->session('userId')) {
            throw new \Exception("Unauthorized", 401);
        }
    }

    public function onAfterExecute()
    {
        return;
    }
}