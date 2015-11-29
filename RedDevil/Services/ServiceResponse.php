<?php

namespace RedDevil\Services;

class ServiceResponse {
    private $message;
    private $errorCode;
    private $model;

    function __construct(integer $errorCode = null, string $message = null, $model = null)
    {
        $this->errorCode = $errorCode;
        $this->message = $message;
        $this->model = $model;
    }

    /**
     * @return bool
     */
    public function hasError() : bool
    {
        return $this->errorCode != null;
    }

    /**
     * @return string
     */
    public function getMessage() : string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message)
    {
        $this->message = $message;
    }

    /**
     * @return null
     */
    public function getErrorCode() : integer
    {
        return $this->errorCode;
    }

    /**
     * @param null $errorCode
     */
    public function setErrorCode(integer $errorCode)
    {
        $this->errorCode = $errorCode;
    }

    /**
     * @return null
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param null $model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }
}