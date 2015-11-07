<?php

namespace RedDevil\ViewHelpers;

class RadioButton extends \RedDevil\ViewHelpers\BaseViewHelper {
    protected $type = 'radio';

    public static function create()
    {
        return new self();
    }

    public function toString()
    {
        $this->output .= $this->newLineBefore === false ? '' : "<br/>\n";

        $this->output .= '<input type="'. $this->type . '" ';
        foreach ($this->attributes as $attributeName => $attributeValue) {
            $this->output .= $attributeName . '="' . $attributeValue . '" ';
        }
        $this->output .= ">\n";
        $this->output .= $this->data;

        $this->output .= $this->newLineAfter === false ? '' : "<br/>\n";

        return $this->output;
    }

    public function render()
    {
        echo $this->toString();
    }
}