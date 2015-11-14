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
        return new ServiceResponse();
    }

    /**
     * @param LoginInputModel $model
     * @return ServiceResponse
     */
    public function login(LoginInputModel $model)
    {

        return new ServiceResponse();
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