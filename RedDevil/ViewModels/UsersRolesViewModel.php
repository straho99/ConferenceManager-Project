<?php

namespace RedDevil\ViewModels;

use RedDevil\Models\User;

class UsersRolesViewModel
{
    private $userId;
    private $username;
    private $fullName;
    private $roleTitles = [];

    public function __construct(User $user)
    {
        $this->userId = $user->getId();
        $this->fullName = $user->getFullname();
        $this->username = $user->getUsername();
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getFullName()
    {
        return $this->fullName;
    }

    public function setFullName($fullName)
    {
        $this->fullName = $fullName;
    }

    public function getRoleTitles()
    {
        return $this->roleTitles;
    }

    public function setRoleTitles($roleTitles)
    {
        $this->roleTitles = $roleTitles;
    }

    /**
     * @return mixed
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
}
