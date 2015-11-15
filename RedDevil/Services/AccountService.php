<?php

namespace RedDevil\Services;

use RedDevil\InputModels\Account\LoginInputModel;
use RedDevil\InputModels\Account\RegisterInputModel;
use RedDevil\Models\User;

class AccountService extends BaseService {

    /**
     * @param RegisterInputModel $model
     * @return ServiceResponse
     */
    public function register(RegisterInputModel $model)
    {
        $user = new User(
            $model->getUsername(),
            password_hash($model->getPassword(), PASSWORD_DEFAULT),
            $model->getEmail()
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
    public function login(LoginInputModel $model)
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
     * @return ServiceResponse
     */
    public function logout()
    {
        session_start();
        session_destroy();
        return new ServiceResponse();
    }
}