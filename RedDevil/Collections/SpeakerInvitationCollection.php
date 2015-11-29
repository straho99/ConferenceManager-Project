<?php

namespace RedDevil\Collections;

use RedDevil\Models\Speakerinvitation;

class SpeakerinvitationCollection
{
    /**
     * @var Speakerinvitation[];
     */
    private $collection = [];

    public function __construct($models = [])
    {
        $this->collection = $models;
    }

    /**
     * @return Speakerinvitation[]
     */
    public function getSpeakerinvitations()
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