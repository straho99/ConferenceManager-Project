<?php

namespace RedDevil\ViewHelpers;

class ActionLink extends BaseViewHelper {

    public static function create()
    {
        return new self();
    }

    public function toString()
    {
        $url = $this->getAttribute('href');
        $data = $this->data;
        $this->output .= $this->newLineBefore === false ? '' : "<br/>\n";

        $this->output .= "<a href='$url' ";
        foreach ($this->attributes as $attributeName => $attributeValue) {
            $this->output .= $attributeName . '="' . $attributeValue . '" ';
        }
        $this->output .= ">$data</a>";

        $this->output .= $this->newLineAfter === false ? '' : "<br/>\n";

        return $this->output;
    }

    public function render()
    {
        echo $this->toString();
    }
}