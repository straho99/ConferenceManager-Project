<?php

namespace RedDevil\Collections;

use RedDevil\Models\Message;

class MessageCollection
{
    /**
     * @var Message[];
     */
    private $collection = [];

    public function __construct($models = [])
    {
        $this->collection = $models;
    }

    /**
     * @return Message[]
     */
    public function getMessages()
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