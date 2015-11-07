<?php

namespace RedDevil\ViewHelpers;

class TextArea extends \RedDevil\ViewHelpers\BaseViewHelper {
    private $rows;
    private $cols;

    public static function create()
    {
        return new self();
    }
    /**
     * @param mixed $cols
     */
    public function setCols($cols)
    {
        $this->cols = $cols;
        return $this;
    }

    /**
     * @param mixed $rows
     */
    public function setRows($rows)
    {
        $this->rows = $rows;
        return $this;
    }

    public function toString()
    {
        $this->output .= $this->newLineBefore === false ? '' : "<br/>\n";

        $this->output .= "<textarea ";
        foreach ($this->attributes as $attributeName => $attributeValue) {
            $this->output .= $attributeName . '="' . $attributeValue . '" ';
        }
        $this->output .= ">\n" . $this->data . "\n" . "</textarea>\n";

        $this->output .= $this->newLineAfter === false ? '' : "<br/>\n";

        return $this->output;
    }

    public function render()
    {
        echo $this->toString();
    }
}