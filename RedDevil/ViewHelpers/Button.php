<?php

namespace RedDevil\ViewHelpers;

class Button extends \RedDevil\ViewHelpers\BaseViewHelper {

    public static function create()
    {
        return new self();
    }

    public function toString()
    {
        $this->output .= $this->newLineBefore === false ? '' : "<br/>\n";

        $this->output .= '<button ';
        foreach ($this->attributes as $attributeName => $attributeValue) {
            $this->output .= $attributeName . '="' . $attributeValue . '" ';
        }
        $this->output .= ">\n";
        $this->output .= $this->data;
        $this->output .= "</button>";

        $this->output .= $this->newLineAfter === false ? '' : "<br/>\n";

        return $this->output;
    }

    public function render()
    {
        echo $this->toString();
    }
}