<?php

namespace RedDevil\InputModels\Account;

use RedDevil\InputModels\BaseInputModel;

class RegisterInputModel extends BaseInputModel
{
    private $username;
    private $email;
    private $password;
    private $confirmPassword;

    function __construct()
    {
        parent::__construct();
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
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getConfirmPassword()
    {
        return $this->confirmPassword;
    }

    /**
     * @param mixed $confirmPassword
     */
    public function setConfirmPassword($confirmPassword)
    {
        $this->confirmPassword = $confirmPassword;
    }

    public function validate()
    {
        $this->validator->setRule('minlength', $this->username, 3,
            'Username | Username must be at least 3 characters long.');

        $this->validator->setRule('email', $this->email, "Email | Invalid email.");

        $this->validator->setRule('minlength', $this->password, 3,
            'Password | Password must be at least 3 characters long.');

        $this->validator->setRule('minlength', $this->confirmPassword, 3,
            'Confirm Password | Confirm Password must be at least 3 characters long.');

        $this->validator->setRule('matches', $this->password, $this->confirmPassword,
            'Confirm Password | Passwords do not match.');

        parent::validate();
    }
}