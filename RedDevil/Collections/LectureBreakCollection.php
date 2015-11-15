<?php

namespace RedDevil\Collections;

use RedDevil\Models\LectureBreak;

class LectureBreakCollection
{
    /**
     * @var LectureBreak[];
     */
    private $collection = [];

    public function __construct($models = [])
    {
        $this->collection = $models;
    }

    /**
     * @return LectureBreak[]
     */
    public function getLectureBreaks()
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