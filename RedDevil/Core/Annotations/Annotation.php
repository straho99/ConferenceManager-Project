<?php

namespace RedDevil\Core\Annotations;

abstract class Annotation {
    public abstract function onBeforeExecute();

    public abstract function onAfterExecute();
}