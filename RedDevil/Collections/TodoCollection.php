<?php

namespace SoftUni\Collections;

use SoftUni\Models\Todo;

class TodoCollection
{
    /**
     * @var Todo[];
     */
    private $collection = [];

    public function __construct($models = [])
    {
        $this->collection = $models;
    }

    /**
     * @param callable $callback
     */
    public function each(Callable $callback)
    {
        foreach ($this->collection as $model) {
            $callback($model);
        }
    }
}