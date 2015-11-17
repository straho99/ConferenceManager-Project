<?php

namespace RedDevil\ViewHelpers;

class DateField extends TextField {

    public static function create()
    {
        return new self();
    }

    public function toString()
    {
        $this->type = 'date';
        return parent::toString();
    }

    public function render()
    {
        echo $this->toString();
    }
}