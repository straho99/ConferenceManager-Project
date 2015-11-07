<?php
namespace RedDevil\ViewHelpers;

class TextField extends \RedDevil\ViewHelpers\BaseViewHelper{
    private $label = '';

    protected $type = 'text';

    public static function create()
    {
        return new self();
    }

    public function addLabel($text, $onSameLine = false)
    {
        $this->label = \RedDevil\ViewHelpers\Label::create()
            ->setAttribute('for', $this->attributes['id'])
            ->setData($text)
            ->setNewLineAfter($onSameLine)
            ->toString();

        return $this;
    }

    public function toString()
    {
        $this->output .= $this->label;

        $this->output .= $this->newLineBefore === false ? '' : "<br/>\n";

        $this->output .= '<input type="'. $this->type . '" ';
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