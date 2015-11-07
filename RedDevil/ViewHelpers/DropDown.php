<?php

namespace RedDevil\ViewHelpers;


class DropDown extends \RedDevil\ViewHelpers\BaseViewHelper {
    private $options = '';

    public static function create()
    {
        return new self();
    }

    public function setDefault($text)
    {
        $default = "\t<option value=\"\">" . $text . "</option>\n";
        $this->options = $default . $this->options;
        return $this;
    }

    public function setData($data, $value = 'id', $text = 'value', $selectedValue = null)
    {
        foreach ($data as $row) {
            $selected = $row[$value] == $selectedValue ? " selected ": "";
            $this->options .= "\t<option "
                . "value='" . $row[$value] . "''"
                . $selected
                . ">"
                . $row[$text]
                . "</option>\n";
        }

        return $this;
    }

    public function toString()
    {
        $this->output .= $this->newLineBefore === false ? '' : "<br/>\n";

        $this->output .= '<select ';
        foreach ($this->attributes as $attributeName => $attributeValue) {
            $this->output .= $attributeName . '="' . $attributeValue . '" ';
        }
        $this->output .= ">\n";
        $this->output .= $this->options;
        $this->output .= "</select>\n";

        $this->output .= $this->newLineAfter === false ? '' : "<br/>\n";

        return $this->output;
    }

    public function render()
    {
        echo $this->toString();
    }
}