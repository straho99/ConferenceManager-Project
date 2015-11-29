<?php

namespace RedDevil\Collections;

use RedDevil\Models\Lecturebreak;

class LecturebreakCollection
{
    /**
     * @var Lecturebreak[];
     */
    private $collection = [];

    public function __construct($models = [])
    {
        $this->collection = $models;
    }

    /**
     * @return Lecturebreak[]
     */
    public function getLecturebreaks()
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