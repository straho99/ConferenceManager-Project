<?php

namespace RedDevil\InputModels;

use RedDevil\Core\Validation;

class BaseInputModel {

    protected $errors = [];
    protected $validator;

    public function __construct()
    {
        $this->validator = new Validation();
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return count($this->errors) > 0;
    }

    public function getErrors() {
        return $this->errors;
    }

    public function error($propertyName)
    {
        return $this->errors[$propertyName];
    }

    public function validate()
    {
        $this->validator->validate();
        $errorsFound = $this->validator->getErrors();
        foreach ($errorsFound as $error) {
            $errorArray = explode('|', $error);
            if (count($errorArray) < 2) {
                $errorArray[] = $error;
            }
            $this->errors[] = new PropertyError(trim($errorArray[0]), trim($errorArray[1]));
        }
    }
}