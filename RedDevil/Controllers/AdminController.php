<?php

namespace RedDevil\Controllers;

use RedDevil\Services\AdminServices;
use RedDevil\View;
use RedDevil\InputModels\Admin\AddRoleInputModel;
use RedDevil\ViewModels\UsersRolesPageViewModel;

class AdminController extends BaseController
{

    /**
     * @Role('admin')
     * @Route('admin/manageroles')
     * @return View
     */
    public function manageRoles()
    {
        $service = new AdminServices($this->dbContext);
        $response = $service->getUsersRoles();
        $this->processResponse($response);

        $model = new UsersRolesPageViewModel();
        $model->setUsersRoles($response->getModel());

        $rolesTitles = [];

        $roles = $this->dbContext->getRolesRepository()
            ->findAll();
        foreach ($roles->getRoles() as $role) {
            $rolesTitles[] = [
                'title' => $role->getName(),
                'roleId' => $role->getId()
            ];
        }
        $model->setRoleTitles($rolesTitles);

        return new View('Admin', 'usersroles', $model);
    }

    /**
     * @Method('POST')
     * @Role('admin')
     * @Validatetoken('token')
     * @param AddRoleInputModel $model
     * @return View
     * @throws \Exception
     */
    public function addRole(AddRoleInputModel $model)
    {
        $service = new AdminServices($this->dbContext);
        $response = $service->addRoleToUser($model);
        $this->processResponse($response);
        $this->redirect('admin', 'manageRoles');
    }
}
