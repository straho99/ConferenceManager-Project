<?php

namespace RedDevil\Core\Annotations;

use RedDevil\Core\HttpContext;

class RoleAnnotation extends Annotation {

    private $role = '';

    public function __construct($allowedRole)
    {
        $this->role = $allowedRole;
    }

    public function onBeforeExecute()
    {
        $context = HttpContext::getInstance();
        if (!$context->session('userId')) {
            throw new \Exception("Unauthorized", 401);
        }

        if (false) {
            if (!$context->getIdentity()->isInRole($this->role)) {
                throw new \Exception("Unauthorized", 401);
            }
        }
    }

    public function onAfterExecute()
    {
        return;
    }
}