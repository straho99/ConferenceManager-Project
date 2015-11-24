<?php

namespace RedDevil\ViewHelpers;

class DateTimeField extends TextField {
    public static function create()
    {
        return new self();
    }

    public function toString()
    {
        $this->type = 'datetime';
        return parent::toString();
    }

    public function render()
    {
        echo $this->toString();
    }
}