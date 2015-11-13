<?php

namespace RedDevil\InputModels;

class PropertyError {

    private $property;

    private $message;

    function __construct($property, $message)
    {
        $this->setProperty($property);
        $this->setMessage($message);
    }

    /**
     * @return mixed
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * @param mixed $property
     */
    public function setProperty($property)
    {
        $this->property = $property;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }


}