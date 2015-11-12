<?php

namespace RedDevil\Core\Annotations;

use RedDevil\Core\HttpContext;

abstract class Annotation {
    public abstract function onBeforeExecute();

    public abstract function onAfterExecute();
}