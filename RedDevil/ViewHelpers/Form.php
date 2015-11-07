<?php

namespace RedDevil\ViewHelpers;

class Form extends \RedDevil\ViewHelpers\BaseViewHelper {
    private $name;
    private $method;
    private $action;

    public function __construct($name, $method = 'post', $action = '')
    {
        $this->name = $name;
        $this->method = $method;
        $this->action = $action;
    }

    public function Open()
    {
        echo "<form name=\"" . $this->name . "\" action=\"" . $this->action . "\" method=\"" . $this->method . "\">\n";
    }

    public function Close()
    {
        echo "</form>\n";
    }
}