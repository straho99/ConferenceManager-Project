<?php

namespace RedDevil\Collections;

use RedDevil\Models\Conferencesparticipant;

class ConferencesparticipantCollection
{
    /**
     * @var Conferencesparticipant[];
     */
    private $collection = [];

    public function __construct($models = [])
    {
        $this->collection = $models;
    }

    /**
     * @return Conferencesparticipant[]
     */
    public function getConferencesparticipants()
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