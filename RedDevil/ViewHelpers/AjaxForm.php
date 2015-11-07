<?php

namespace RedDevil\ViewHelpers;

class AjaxForm extends \RedDevil\ViewHelpers\BaseViewHelper {
    private $formId;
    private $url;
    private $controller;
    private $action;
    private $method;
    private $resultsContainer;

    private $fields = [];
    private $buttonId = '';
    protected $output = '';

    public function __construct($formId, $url, $resultsContainer, $controller = '', $action = '', $method = 'POST')
    {
        $this->formId = $formId;
        $this->url = $url;
        $this->controller = $controller;
        $this->action = $action;
        $this->method = $method;
        $this->resultsContainer = $resultsContainer;
    }

    public function addTextField(\RedDevil\ViewHelpers\TextField $textField)
    {
        $this->fields[] = $textField;
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

        $this->output .= "<div " . "id='" . $this->formId . "' ";
        foreach ($this->attributes as $attributeName => $attributeValue) {
            $this->output .= $attributeName . '="' . $attributeValue . '" ';
        }
        $this->output .= ">\n";

        foreach ($this->fields as $element) {
            $this->output .= "\t" . $element->toString();
        }

        $this->output .= "</div>\n";
        $this->output .= $this->newLineAfter === false ? '' : "<br/>\n";

        $this->output .= $this->renderScript();

        return $this->output;
    }

    public function render()
    {
        echo $this->toString();
    }

    private function renderScript()
    {
        $output = "<script>\n";
        $output .= "\t $('#" . $this->buttonId . "').click(function() {\n";

        $output .= "\t\t $.ajax({\n";
        $output .= "\t\t\t url: '" . $this->url . "',\n";
        $output .= "\t\t\t method: '" . $this->method . "',\n";
        $output .= "\t\t\t data: {\n";

        foreach ($this->fields as $field) {
            if (get_class($field) == 'RedDevil\ViewHelpers\CheckBox') {
                $output .= "\t\t\t\t". $field->getAttribute('name') . ": $(\"input[type='checkbox'][name='" . $field->getAttribute('name') . "']:checked\").first().val(),\n";
            } else if (get_class($field) == 'RedDevil\ViewHelpers\RadioButton') {
                $output .= "\t\t\t\t". $field->getAttribute('name') . ": $(\"input[type='radio'][name='" . $field->getAttribute('name') . "']:checked\").first().val(),\n";
            } else {
                $output .= "\t\t\t\t". $field->getAttribute('name') . ": $('#" . $field->getAttribute('id') . "').val(),\n";
            }
        }
        $output = substr($output, 0, strlen($output) -2) . "\n";
        $output .= "\t\t\t },\n";

        $output .= "\t\t\t success: function(data) {\n";
        $output .= "\t\t\t\t $('" . $this->resultsContainer . "').html(data);\n";
        $output .= "\t\t\t }\n";

        $output .= "\t\t })\n";
        $output .= "\t\t });\n";

        $output .= "console.log($('#" . $this->formId . "').serialize());\n";

        $output .= "</script>\n";

        return $output;
    }
}