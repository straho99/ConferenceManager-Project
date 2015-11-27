<?php

namespace RedDevil\Controllers;

use RedDevil\Services\AdminServices;
use RedDevil\View;
use RedDevil\InputModels\Admin\AddRoleInputModel;

class AdminController extends BaseController {

    public function manageRoles()
    {
        $service = new AdminServices($this->dbContext);
        $response = $service->getUsersRoles();
        $this->processResponse($response);
        return new View('Admin', 'usersroles', $response->getModel());
    }
    
    /**
    * @Method('POST')
    */
    public function addRole(AddRoleInputModel $model)
    {
        $service = new AdminServices($this->dbContext);
        $response = $service->addRoleToUser($model);
        $this->processResponse($response);
        return new View('Admin', 'usersroles', $response->getModel());
    }
}
