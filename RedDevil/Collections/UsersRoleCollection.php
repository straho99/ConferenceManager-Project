<?php

namespace RedDevil\Collections;

use RedDevil\Models\UsersRole;

class UsersRoleCollection
{
    /**
     * @var UsersRole[];
     */
    private $collection = [];

    public function __construct($models = [])
    {
        $this->collection = $models;
    }

    /**
     * @return UsersRole[]
     */
    public function getUsersRoles()
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