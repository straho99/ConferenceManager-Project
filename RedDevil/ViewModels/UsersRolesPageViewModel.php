<?php

namespace RedDevil\ViewModels;


class UsersRolesPageViewModel {
    private $usersRoles = [];
    private $roleTitles = [];

    /**
     * @return mixed
     */
    public function getUsersRoles()
    {
        return $this->usersRoles;
    }

    /**
     * @param mixed $usersRoles
     */
    public function setUsersRoles($usersRoles)
    {
        $this->usersRoles = $usersRoles;
    }

    /**
     * @return mixed
     */
    public function getRoleTitles()
    {
        return $this->roleTitles;
    }

    /**
     * @param mixed $roleTitles
     */
    public function setRoleTitles($roleTitles)
    {
        $this->roleTitles = $roleTitles;
    }
}