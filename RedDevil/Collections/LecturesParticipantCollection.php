<?php

namespace RedDevil\Collections;

use RedDevil\Models\LecturesParticipant;

class LecturesParticipantCollection
{
    /**
     * @var LecturesParticipant[];
     */
    private $collection = [];

    public function __construct($models = [])
    {
        $this->collection = $models;
    }

    /**
     * @return LecturesParticipant[]
     */
    public function getLecturesParticipants()
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