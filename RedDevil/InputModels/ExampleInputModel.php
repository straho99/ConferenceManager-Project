<?php

namespace RedDevil\InputModels;

class ExampleInputModel extends BaseInputModel {

    private $name;
    private $age;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @param mixed $age
     */
    public function setAge($age)
    {
        $this->age = $age;
    }

    public function validate()
    {
        $this->validator->setRule('minlength', $this->name, 5, 'Name | Name must be longer than 4 characters.');
        $this->validator->setRule('gt', $this->age, 18, "Age | Age must be greater than 18.");
        parent::validate();
    }
}