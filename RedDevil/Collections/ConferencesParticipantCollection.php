<?php

namespace RedDevil\Collections;

use RedDevil\Models\ConferencesParticipant;

class ConferencesParticipantCollection
{
    /**
     * @var ConferencesParticipant[];
     */
    private $collection = [];

    public function __construct($models = [])
    {
        $this->collection = $models;
    }

    /**
     * @return ConferencesParticipant[]
     */
    public function getConferencesParticipants()
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