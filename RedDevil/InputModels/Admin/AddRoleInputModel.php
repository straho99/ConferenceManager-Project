<?php

namespace RedDevil\InputModels\Admin;

use RedDevil\InputModels\BaseInputModel;

class AddRoleInputModel extends BaseInputModel {
    private $userId;
    private $roleId;

    function __construct()
    {
        parent::__construct();
    }

    /**
     * @return $userId
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }
    
    /**
     * @return $roleId
     */
    public function getRoleId()
    {
        return $this->roleId;
    }

    /**
     * @param mixed $roleId
     */
    public function setRoleId($roleId)
    {
        $this->userId = $roleId;
    }

    public function validate()
    {
        parent::validate();
    }
}
