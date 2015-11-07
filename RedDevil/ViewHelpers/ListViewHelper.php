<?php

namespace RedDevil\ViewHelpers;

abstract class ListViewHelper extends \RedDevil\ViewHelpers\BaseViewHelper {
    private $liItems = [];
    protected $type;
    
    public function __construct($type = 'ul')
    {
        $this->type = $type;
    }

    public function addLiItem(\RedDevil\ViewHelpers\LiViewHelper $item)
    {
        $this->liItems[] = $item;
    }

    public function toString()
    {
        $this->output .= $this->newLineBefore === false ? '' : "<br/>\n";

        $this->output .= "<". $this->type . " ";
        foreach ($this->attributes as $attributeName => $attributeValue) {
            $this->output .= $attributeName . '="' . $attributeValue . '" ';
        }
        $this->output .= ">\n";

        foreach ($this->liItems as $item) {
            $this->output .= $item->toString();
        }

        $this->output .= "</". $this->type . ">\n";

        $this->output .= $this->newLineAfter === false ? '' : "<br/>\n";

        return $this->output;
    }

    public function render()
    {
        echo $this->toString();
    }
}