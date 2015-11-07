<?php

namespace RedDevil\Controllers;

use RedDevil\Models\UserModel;

class UserController extends BaseController {
    /**
     * @var UserModel
     */
    private $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new \RedDevil\Models\UserModel();
    }

    private function initLogin($username, $password)
    {
        $userInfo = $this->userModel->login($username, $password);
        $_SESSION['userId'] = $userInfo['userId'];
        $_SESSION['username'] = $userInfo['username'];
    }

    public function register()
    {
        if ($this->isPost) {
            try {
                $username = $_POST['username'];
                $password = $_POST['password'];

                $this->userModel->register($username, $password);
                $this->addInfoMessage('Registration successful.');
                $this->initLogin($username, $password);

                $this->redirectToUrl('todos/all');
            } catch(\Exception $ex) {
                $this->addErrorMessage($ex->getMessage());
                $this->redirectToUrl('/user');
            }
        } else {
            \RedDevil\View::$viewBag['title'] = 'Register';
            return new \RedDevil\View('user', 'register');
        }
    }

    public function login()
    {
        if ($this->isPost) {
            try {
                $username = $_POST['username'];
                $password = $_POST['password'];

                $this->initLogin($username, $password);

                $this->redirectToUrl('/todos/all');
            } catch (\Exception $ex) {
                $this->addErrorMessage($ex->getMessage());
                $this->redirectToUrl('/user/login');
            }
        } else {
            \RedDevil\View::$viewBag['title'] = 'Login';
            return new \RedDevil\View('user', 'login');
        }
    }

    public function logout()
    {
        if ($this->isLogged()) {
            $this->userModel->logout();
        }

        $this->redirectToUrl('/');
    }
}