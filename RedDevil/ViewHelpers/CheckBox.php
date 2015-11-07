<?php
/**
 * Created by PhpStorm.
 * User: Strahil
 * Date: 10/1/15
 * Time: 1:39 PM
 */

namespace RedDevil\ViewHelpers;


class CheckBox extends \RedDevil\ViewHelpers\RadioButton {
    public static function create()
    {
        return new self();
    }

    public function toString()
    {
        $this->type = 'checkbox';
        return parent::toString();
    }

    public function render()
    {
        echo $this->toString();
    }
}