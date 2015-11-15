<?php

namespace RedDevil\Collections;

use RedDevil\Models\VenueReservationRequest;

class VenueReservationRequestCollection
{
    /**
     * @var VenueReservationRequest[];
     */
    private $collection = [];

    public function __construct($models = [])
    {
        $this->collection = $models;
    }

    /**
     * @return VenueReservationRequest[]
     */
    public function getVenueReservationRequests()
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