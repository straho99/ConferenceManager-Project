<?php

namespace RedDevil\Services;

use RedDevil\View;
use RedDevil\InputModels\Admin\AddRoleInputModel;
use RedDevil\InputModels\Admin\UsersRolesViewModel;

class AdminServices extends BaseService {

    public function manageRoles()
    {
        $usersRoles = $this->dbContext->getUsersRolesRepository()
            ->findAll();
            
        $users = $this->dbContext->getUsersRepository()
            ->orderBy("username")
            ->findAll();
            
        $models = [];
            
        foreach($usersRoles as $role) {
            $userId = $role->getUserId();
            $roleId = $role->getRoleId();
            
            $roleTitle = $this->dbContext->getRolesRepository()
                ->filterById(" = $roleId")
                ->findOne();
        }
        
    }
    
    public function addRole(AddRoleInputModel $model)
    {
        
    }
}
