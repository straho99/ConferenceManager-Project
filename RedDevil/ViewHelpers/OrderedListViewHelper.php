<?php

namespace RedDevil\ViewHelpers;

class OrderedListViewHelper extends \RedDevil\ViewHelpers\ListViewHelper {

    public function __construct()
    {
        parent::__construct('ol');
    }
}