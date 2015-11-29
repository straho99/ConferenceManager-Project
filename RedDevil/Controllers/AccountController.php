<?php

namespace RedDevil\Controllers;

use RedDevil\Core\HttpContext;
use RedDevil\InputModels\Account\ChangePasswordInputModel;
use RedDevil\InputModels\Account\LoginInputModel;
use RedDevil\InputModels\Account\RegisterInputModel;
use RedDevil\Services\AccountService;
use RedDevil\View;

class AccountController extends BaseController {
    /**
     * @param RegisterInputModel $model
     * @return mixed
     * @Validatetoken('token')
     * @Method('GET', 'POST')
     */
    public function register(RegisterInputModel $model) : View
    {
        if (!$model->isValid()) {
            return new View('account', 'register', $model);
        }

        $service = new AccountService($this->dbContext);
        if (HttpContext::getInstance()->isPost()) {
            $result = $service->register($model);
            if (!$result->hasError()) {
                $this->addInfoMessage('Registration was successful.');
                $this->redirect('home', 'index');
            } else {
                $this->addErrorMessage('Registration failed.');
                $this->redirect('account', 'register');
            }
        } else {
            return new View('account', 'register', new RegisterInputModel());
        }
    }

    /**
     * @param LoginInputModel $model
     * @return mixed
     * @Method('GET', 'POST')
     * @Validatetoken('token')
     */
    public function login(LoginInputModel $model)
    {
        $service = new AccountService($this->dbContext);

        if (HttpContext::getInstance()->isPost()) {
            $result = $service->login($model);
            if (!$result->hasError()) {
                $this->addInfoMessage('Login successful.');
                $this->redirect('home', 'index');
            } else {
                $this->addErrorMessage($result->getMessage());
                $this->redirect('account', 'login');
            }
        } else {
            return new View('account', 'login', new LoginInputModel());
        }
    }

    /**
     * @return \RedDevil\View
     * @Method('GET')
     */
    public function logout()
    {
        $service = new AccountService($this->dbContext);
        $service->logout();
        $this->addInfoMessage('Logout successful.');
        $this->redirectToUrl('/');
    }

    /**
     * @param ChangePasswordInputModel $model
     * @Validatetoken('token')
     * @return mixed
     * @throws \Exception
     */
    public function changePassword(ChangePasswordInputModel $model) : View
    {
        if (!HttpContext::getInstance()->getIdentity()->isAuthorised()) {
            throw new \Exception('Unauthorised', 401);
        }

        if (!$model->isValid()) {
            return new View('account', 'changePassword', $model);
        }

        $service = new AccountService($this->dbContext);
        if (HttpContext::getInstance()->isPost()) {
            $result = $service->changepassword($model);
            if (!$result->hasError()) {
                $this->addInfoMessage($result->getMessage());
                $this->redirect('home', 'index');
            } else {
                $this->addErrorMessage($result->getMessage());
                $this->redirect('account', 'register');
            }
        } else {
            return new View('account', 'changePassword', new ChangePasswordInputModel());
        }
    }
}