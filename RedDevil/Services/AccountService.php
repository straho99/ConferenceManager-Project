<?php

namespace RedDevil\Services;

use RedDevil\Core\HttpContext;
use RedDevil\Core\Identity\CMUser;
use RedDevil\InputModels\Account\ChangePasswordInputModel;
use RedDevil\InputModels\Account\LoginInputModel;
use RedDevil\InputModels\Account\RegisterInputModel;
use RedDevil\Models\User;

class AccountService extends BaseService {

    /**
     * @param RegisterInputModel $model
     * @return ServiceResponse
     */
    public function register(RegisterInputModel $model) : ServiceResponse
    {
        $user = new User(
            $model->getUsername(),
            $model->getEmail(),
            password_hash($model->getPassword(), PASSWORD_DEFAULT),
            $model->getFullname(),
            $model->getTelephone()
        );
        $this->dbContext->getUsersRepository()->add($user);
        $this->dbContext->saveChanges();
        $_SESSION['userId'] = $user->getId();
        $_SESSION['username'] = $user->getUsername();

        return new ServiceResponse();
    }

    /**
     * @param LoginInputModel $model
     * @return ServiceResponse
     */
    public function login(LoginInputModel $model)  : ServiceResponse
    {
        $user = $this->dbContext->getUsersRepository()
            ->filterByUsername(' = "' . $model->getUsername() . '"')
            ->findOne();
        if ($user->getUsername() == null) {
            return new ServiceResponse(1, 'Login failed. No such user.');
        }

        if (password_verify($model->getPassword(), $user->getPassword())) {
            $_SESSION['userId'] = $user->getId();
            $_SESSION['username'] = $user->getUsername();
            return new ServiceResponse(null, 'Login successful.');
        }

        return new ServiceResponse(1, 'Wrong password.');
    }

    /**
     * @param ChangePasswordInputModel $model
     * @return ServiceResponse
     */
    public function changePassword(ChangePasswordInputModel $model)  : ServiceResponse
    {
        $user = $this->dbContext->getUsersRepository()
            ->filterByUsername(' = "' . HttpContext::getInstance()->getIdentity()->getUsername() . '"')
            ->findOne();
        if (!password_verify($model->getCurrentPassword(), $user->getPassword())) {
            return new ServiceResponse(1, 'Wrong current password.');
        }

        $user->setPassword(password_hash($model->getNewPassword(), PASSWORD_DEFAULT));
        $this->dbContext->saveChanges();
        return new ServiceResponse(null, 'Password changed successfully.');
    }

    /**
     * @return ServiceResponse
     */
    public function logout() : ServiceResponse
    {
        session_start();
        session_destroy();
        return new ServiceResponse();
    }
}