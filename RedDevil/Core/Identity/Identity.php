<?php

namespace RedDevil\Core\Identity;

use RedDevil\Config\DatabaseConfig;
use RedDevil\Core\DatabaseData;

class Identity {
    private static $_instance = null;
    private $db;

    private function __construct()
    {
        $this->db = DatabaseData::getInstance(DatabaseConfig::DB_INSTANCE);
    }

    /**
     * @return mixed
     */
    public function getUserId() : integer
    {
        if (array_key_exists('userId', $_SESSION)) {
            return $_SESSION['userId'];
        } else {
            return null;
        }
    }

    /**
     * @return mixed
     */
    public function getUsername() : string
    {
        if (array_key_exists('username', $_SESSION)) {
            $result = $_SESSION['username'];
            return $result;
        } else {
            return null;
        }
    }

    /**
     * @return bool
     */
    public function isAuthorised() : bool
    {
        if ($this->getUserId() == null) {
            return false;
        }
        return true;
    }

    /**
     * @param $role
     * @return bool
     */
    public function isInRole(string $role) : bool
    {
        if (!$this->isAuthorised()) {
            return false;
        }

        $query = <<<TAG
select name
from roles
join users_roles
on roles.`id` = users_roles.`role_id`
where users_roles.`user_id` = ?
TAG;

        $statement = $this->db->prepare($query);
        $statement->execute([$this->getUserId()]);
        $userRoles = $statement->fetchAll();
        foreach ($userRoles as $dbRole) {
            if ($dbRole['name'] == $role) {
                return true;
            }
        }
        return false;
    }

    /**
     *
     * @return \RedDevil\Core\Identity\Identity
     */
    public static function getInstance() {
        if (self::$_instance == null) {
            self::$_instance = new Identity();
        }
        return self::$_instance;
    }
}