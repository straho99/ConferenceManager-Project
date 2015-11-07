<?php

namespace RedDevil\ViewHelpers;

class PasswordField extends \RedDevil\ViewHelpers\TextField {

    public static function create()
    {
        return new self();
    }

    public function toString()
    {
        $this->type = 'password';
        return parent::toString();
    }

    public function render()
    {
        echo $this->toString();
    }
}