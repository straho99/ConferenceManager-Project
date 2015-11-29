<?php

namespace RedDevil\Collections;

use RedDevil\Models\Lecturesparticipant;

class LecturesparticipantCollection
{
    /**
     * @var Lecturesparticipant[];
     */
    private $collection = [];

    public function __construct($models = [])
    {
        $this->collection = $models;
    }

    /**
     * @return Lecturesparticipant[]
     */
    public function getLecturesparticipants()
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