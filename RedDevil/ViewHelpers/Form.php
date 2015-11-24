<?php

namespace RedDevil\ViewHelpers;

use RedDevil\ViewHelpers\ActionLink;
use RedDevil\ViewHelpers\Button;
use RedDevil\ViewHelpers\CheckBox;
use RedDevil\ViewHelpers\CSFRToken;
use RedDevil\ViewHelpers\DateField;
use RedDevil\ViewHelpers\DateTimeField;
use RedDevil\ViewHelpers\DropDown;
use RedDevil\ViewHelpers\Label;
use RedDevil\ViewHelpers\PasswordField;
use RedDevil\ViewHelpers\RadioButton;
use RedDevil\ViewHelpers\SubmitButton;
use RedDevil\ViewHelpers\TextArea;

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

    public function addDateField(DateField $dateField)
    {
        $this->fields[] = $dateField;
    }

    public function addDateTimeField(DateTimeField $dateTimeField)
    {
        $this->fields[] = $dateTimeField;
    }

    public function addSubmitButton(SubmitButton $submit)
    {
        $this->fields[] = $submit;
    }

    public function addActionLink(ActionLink $link)
    {
        $this->fields[] = $link;
    }

    public function addPasswordField(PasswordField $passwordField)
    {
        $this->fields[] = $passwordField;
    }

    public function addLabel(Label $label)
    {
        $this->fields[] = $label;
    }

    public function addCheckbox(CheckBox $checkbox)
    {
        $this->fields[] = $checkbox;
    }

    public function addDropDown(DropDown $dropdown)
    {
        $this->fields[] = $dropdown;
    }

    public function addRadioButton(RadioButton $radiobutton)
    {
        $this->fields[] = $radiobutton;
    }

    public function addTextArea(TextArea $textarea)
    {
        $this->fields[] = $textarea;
    }

    public function addButton(Button $button)
    {
        $this->fields[] = $button;
        if (!$button->getAttribute('id')) {
            throw new \Exception("Missing attribute 'id' in form button.");
        }
        $this->buttonId = $button->getAttribute('id');
    }

    public function addCSRFToken(CSFRToken $token)
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