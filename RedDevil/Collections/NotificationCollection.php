<?php

namespace RedDevil\Collections;

use RedDevil\Models\Notification;

class NotificationCollection
{
    /**
     * @var Notification[];
     */
    private $collection = [];

    public function __construct($models = [])
    {
        $this->collection = $models;
    }

    /**
     * @return Notification[]
     */
    public function getNotifications()
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