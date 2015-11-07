<?php

namespace RedDevil\ViewHelpers;

class LiViewHelper extends \RedDevil\ViewHelpers\BaseViewHelper {

    public static function create()
    {
        return new self();
    }

    public function toString()
    {
        $this->output .= '<li ';
        foreach ($this->attributes as $attributeName => $attributeValue) {
            $this->output .= $attributeName . '="' . $attributeValue . '" ';
        }
        $this->output .= ">\n";

        $this->output .= "\t" . $this->data . "</li>\n";

        return $this->output;
    }

    public function render()
    {
        echo $this->toString();
    }
}