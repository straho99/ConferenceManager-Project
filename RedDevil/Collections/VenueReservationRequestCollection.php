<?php

namespace RedDevil\Collections;

use RedDevil\Models\Venuereservationrequest;

class VenuereservationrequestCollection
{
    /**
     * @var Venuereservationrequest[];
     */
    private $collection = [];

    public function __construct($models = [])
    {
        $this->collection = $models;
    }

    /**
     * @return Venuereservationrequest[]
     */
    public function getVenuereservationrequests()
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