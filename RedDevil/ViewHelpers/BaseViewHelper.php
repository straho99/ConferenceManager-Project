<?php
namespace RedDevil\ViewHelpers;

abstract class BaseViewHelper {
    protected $newLineBefore = false;
    protected $newLineAfter = true;

    /**
     * @param boolean $newLineBefore
     */
    public function setNewLineBefore($newLineBefore = false)
    {
        $this->newLineBefore = $newLineBefore;
        return $this;
    }

    /**
     * @param boolean $newLineAfter
     */
    public function setNewLineAfter($newLineAfter = true)
    {
        $this->newLineAfter = $newLineAfter;
        return $this;
    }

    protected $attributes = [];
    protected $data;
    protected $output = '';

    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    public function toString()
    {
    }

    public function render()
    {
    }

    public static function create()
    {
    }

    public function setAttribute($attributeName, $attributeValue)
    {
        $this->attributes[$attributeName] = $attributeValue;
        return $this;
    }

    public function getAttribute($attributeName)
    {
        return $this->attributes[$attributeName];
    }
}