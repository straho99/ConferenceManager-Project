<?php

namespace RedDevil\Controllers;

use RedDevil\View;
use RedDevil\ViewModels\UserInfoModel;

class UsersController extends BaseController {

    /**
     * @param $username
     * @Method('GET')
     * @Route('users/{string $username}')
     * @return View
     * @throws \Exception
     */
    public function users($username)
    {
        $user = $this->dbContext->getUsersRepository()
            ->filterByUsername(" = '$username'")
            ->findOne();
        if ($user->getUsername() == null) {
            throw new \Exception('Not found', 404);
        }

        $userInfoModel = new UserInfoModel($user);

        return new View('Users', 'users', $userInfoModel);
    }
}