<?php
namespace RedDevil\ViewHelpers;

class Label extends BaseViewHelper{

    public static function create()
    {
        return new self();
    }

    public function toString()
    {
        $this->output .= $this->newLineBefore === false ? '' : "<br/>\n";
        $this->output .= '<label ';
        foreach ($this->attributes as $attributeName => $attributeValue) {
            $this->output .= $attributeName . '="' . $attributeValue . '" ';
        }
        $this->output .= ">" . $this->data . "</label>\n";
        $this->output .= $this->newLineAfter === false ? '' : "<br/>\n";
        return $this->output;
    }

    public function render()
    {
        echo $this->toString();
    }
}