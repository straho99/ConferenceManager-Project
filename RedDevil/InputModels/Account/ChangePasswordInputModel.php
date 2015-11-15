<?php
/**
 * Created by PhpStorm.
 * User: Strahil
 * Date: 11/15/15
 * Time: 1:53 PM
 */

namespace RedDevil\InputModels\Account;


use RedDevil\InputModels\BaseInputModel;

class ChangePasswordInputModel extends BaseInputModel {
    private $currentPassword;
    private $newPassword;
    private $confirmPassword;

    function __construct()
    {
        parent::__construct();
    }


    /**
     * @return mixed
     */
    public function getCurrentPassword()
    {
        return $this->currentPassword;
    }

    /**
     * @param mixed $currentPassword
     */
    public function setCurrentPassword($currentPassword)
    {
        $this->currentPassword = $currentPassword;
    }

    /**
     * @return mixed
     */
    public function getNewPassword()
    {
        return $this->newPassword;
    }

    /**
     * @param mixed $newPassword
     */
    public function setNewPassword($newPassword)
    {
        $this->newPassword = $newPassword;
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
        $this->validator->setRule('minlength', $this->newPassword, 3,
            'newPassword | New password must be at least 3 characters long.');

        $this->validator->setRule('matches', $this->newPassword, $this->confirmPassword,
            'confirmPassword | Passwords do not match.');

        parent::validate();
    }
}