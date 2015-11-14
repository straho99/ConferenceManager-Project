<?php

namespace RedDevil\Services;

class ServiceResponse {
    private $message;
    private $errorCode;

    function __construct($errorCode = null, $message = null)
    {
        $this->errorCode = $errorCode;
        $this->message = $message;
    }

    /**
     * @return bool
     */
    public function hasError()
    {
        return $this->errorCode != null;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return null
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * @param null $errorCode
     */
    public function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;
    }
}