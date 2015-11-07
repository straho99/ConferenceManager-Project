<?php

namespace RedDevil\ViewHelpers;

class SubmitButton extends \RedDevil\ViewHelpers\TextField {
    public static function create()
    {
        return new self();
    }

    public function toString()
    {
        $this->type = 'submit';
        return parent::toString();
    }

    public function render()
    {
        echo $this->toString();
    }
}