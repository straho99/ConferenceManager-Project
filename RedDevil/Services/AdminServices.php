<?php

namespace RedDevil\Services;

use RedDevil\InputModels\Admin\AddRoleInputModel;
use RedDevil\Models\UsersRole;
use RedDevil\ViewModels\UsersRolesViewModel;

class AdminServices extends BaseService {

    public function getUsersRoles()
    {
        $users = $this->dbContext->getUsersRepository()
            ->orderBy("username")
            ->findAll();
            
        $models = [];

        foreach ($users->getUsers() as $user) {
            $model = new UsersRolesViewModel($user);

            $userId = $user->getId();
            $userRoles = $this->dbContext->getUsersRolesRepository()
                ->filterByUser_id(" = $userId")
                ->findAll();

            $titles = [];
            foreach ($userRoles->getUsersRoles() as $userRole) {
                $roleId = $userRole->getRole_id();
                $title = $this->dbContext->getRolesRepository()
                    ->filterById(" = $roleId")
                    ->findOne()
                    ->getName();

                $titles[] = $title;
            }

            $model->setRoleTitles($titles);
            $models[] = $model;
        }

        return new ServiceResponse(null, null, $models);
    }
    
    public function addRoleToUser(AddRoleInputModel $model)
    {
        $roleId = $model->getRoleId();
        $userId = $model->getUserId();

        $testRole = $this->dbContext->getUsersRolesRepository()
            ->filterByUser_id(" = $userId")
            ->filterByRole_id(" = $roleId")
            ->findOne();
        if ($testRole->getId() !== null) {
            return new ServiceResponse(1, "User is already assigned this role.");
        }

        $userRole = new UsersRole($userId, $roleId);
        $this->dbContext->getUsersRolesRepository()
            ->add($userRole);
        $this->dbContext->saveChanges();

        return new ServiceResponse(null, "Role assigned to user.");
    }
}
