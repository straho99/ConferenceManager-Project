<?php

namespace RedDevil\Collections;

use RedDevil\Models\SpeakerInvitation;

class SpeakerInvitationCollection
{
    /**
     * @var SpeakerInvitation[];
     */
    private $collection = [];

    public function __construct($models = [])
    {
        $this->collection = $models;
    }

    /**
     * @return SpeakerInvitation[]
     */
    public function getSpeakerInvitations()
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