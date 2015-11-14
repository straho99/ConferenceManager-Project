<?php

namespace RedDevil\ViewHelpers;

class Form extends \RedDevil\ViewHelpers\BaseViewHelper {
    private $formId;
    private $url;
    private $controller;
    private $action;
    private $method;

    private $fields = [];
    private $buttonId = '';
    protected $output = '';

    public function __construct($formId, $url, $controller = '', $action = '', $method = 'POST')
    {
        $this->formId = $formId;
        $this->url = $url;
        $this->controller = $controller;
        $this->action = $action;
        $this->method = $method;
    }

    public function addTextField(\RedDevil\ViewHelpers\TextField $textField)
    {
        $this->fields[] = $textField;
    }

    public function addSubmitButton(\RedDevil\ViewHelpers\SubmitButton $submit)
    {
        $this->fields[] = $submit;
    }

    public function addActionLink(\RedDevil\ViewHelpers\ActionLink $link)
    {
        $this->fields[] = $link;
    }

    public function addPasswordField(\RedDevil\ViewHelpers\PasswordField $passwordField)
    {
        $this->fields[] = $passwordField;
    }

    public function addLabel(\RedDevil\ViewHelpers\Label $label)
    {
        $this->fields[] = $label;
    }

    public function addCheckbox(\RedDevil\ViewHelpers\CheckBox $checkbox)
    {
        $this->fields[] = $checkbox;
    }

    public function addDropDown(\RedDevil\ViewHelpers\DropDown $dropdown)
    {
        $this->fields[] = $dropdown;
    }

    public function addRadioButton(\RedDevil\ViewHelpers\RadioButton $radiobutton)
    {
        $this->fields[] = $radiobutton;
    }

    public function addTextArea(\RedDevil\ViewHelpers\TextArea $textarea)
    {
        $this->fields[] = $textarea;
    }

    public function addButton(\RedDevil\ViewHelpers\Button $button)
    {
        $this->fields[] = $button;
        if (!$button->getAttribute('id')) {
            throw new \Exception("Missing attribute 'id' in form button.");
        }
        $this->buttonId = $button->getAttribute('id');
    }

    public function addCSRFToken(\RedDevil\ViewHelpers\CSFRToken $token)
    {
        $this->fields[] = $token;
    }

    public function toString()
    {
        $this->output .= $this->newLineBefore === false ? '' : "<br/>\n";

        $this->output .= "<form " . "id='" . $this->formId . "' ";
        foreach ($this->attributes as $attributeName => $attributeValue) {
            $this->output .= $attributeName . '="' . $attributeValue . '" ';
        }
        $this->output .= ">\n";

        foreach ($this->fields as $element) {
            $this->output .= "\t" . $element->toString();
        }

        $this->output .= "</form>\n";
        $this->output .= $this->newLineAfter === false ? '' : "<br/>\n";

        return $this->output;
    }

    public function render()
    {
        echo $this->toString();
    }
}