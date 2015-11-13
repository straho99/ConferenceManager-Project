<?php

namespace RedDevil\Controllers;

use RedDevil\View;

class AccountController extends BaseController {

    /**
     * @return \RedDevil\View
     * @Method('GET')
     */
    public function register()
    {
        return new View('account', 'register');
    }

    /**
     * @return \RedDevil\View
     * @Method('GET')
     */
    public function login()
    {
        return new View('account', 'login');
    }

    /**
     * @return \RedDevil\View
     * @Method('GET')
     */
    public function logout()
    {
        //Todo: add logout logic here.
        $this->redirectToUrl('/');
    }
}