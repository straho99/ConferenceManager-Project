<?php

namespace RedDevil\Controllers;

use RedDevil\Core\HttpContext;
use RedDevil\InputModels\Account\RegisterInputModel;
use RedDevil\Services\AccountService;
use RedDevil\View;

class AccountController extends BaseController {
    /**
     * @param RegisterInputModel $model
     * @return View
     * @Method('GET', 'POST')
     */
    public function register(RegisterInputModel $model)
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
                $this->redirect('home', 'index');
            }
        } else {
            return new View('account', 'register', new RegisterInputModel());
        }
    }

    /**
     * @return \RedDevil\View
     * @Method('GET', 'POST')
     */
    public function login()
    {
        if (HttpContext::getInstance()->isPost()) {
            //TODO: add login logic
        } else {
            return new View('account', 'login');
        }
    }

    /**
     * @return \RedDevil\View
     * @Method('GET')
     */
    public function logout()
    {
//        $accountService = new AccountService();

        $this->redirectToUrl('/');
    }
}