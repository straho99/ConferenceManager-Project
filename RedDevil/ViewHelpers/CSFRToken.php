<?php

namespace RedDevil\ViewHelpers;

class CSFRToken extends \RedDevil\ViewHelpers\BaseViewHelper {

    private $token;

    public static function create()
    {
        return new self();
    }

    public function toString()
    {
        if (!$this->getAttribute('name')) {
            throw new \Exception('The CSFR token must have a name.');
        }

        $this->token = rand(1, 1000000000);
        $_SESSION[$this->getAttribute('name')] = $this->token;

        $this->output .= $this->newLineBefore === false ? '' : "<br/>\n";

        $this->output .= "<input type=\"hidden\" value=\"" . $this->token . "\" ";

        foreach ($this->attributes as $attributeName => $attributeValue) {
            $this->output .= $attributeName . '="' . $attributeValue . '" ';
        }

        $this->output .= "/>\n";

        $this->output .= $this->newLineAfter === false ? '' : "<br/>\n";

        return $this->output;
    }

    public function render()
    {
        echo $this->toString();
    }
}