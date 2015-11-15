<?php

namespace RedDevil\Collections;

use RedDevil\Models\Role;

class RoleCollection
{
    /**
     * @var Role[];
     */
    private $collection = [];

    public function __construct($models = [])
    {
        $this->collection = $models;
    }

    /**
     * @return Role[]
     */
    public function getRoles()
    {
        return $this->collection;
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