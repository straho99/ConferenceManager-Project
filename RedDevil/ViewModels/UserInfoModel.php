<?php

namespace RedDevil\ViewModels;

use RedDevil\Core\Identity\CMUser;
use RedDevil\Models\User;

class UserInfoModel {
    private $username;
    private $email;
    private $fullname;
    private $telephone;

    function __construct(User $user)
    {
        $this->username = $user->getUsername();
        $this->email = $user->getEmail();
        $this->fullname = $user->getFullName();
        $this->telephone = $user->getTelephone();
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getFullname()
    {
        return $this->fullname;
    }

    /**
     * @param mixed $fullname
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;
    }

    /**
     * @return mixed
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param mixed $telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }
}