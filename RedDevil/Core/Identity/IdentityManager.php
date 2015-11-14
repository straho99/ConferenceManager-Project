<?php

namespace RedDevil\Core\Identity;

use RedDevil\Config\DatabaseConfig;
use RedDevil\Config\IdentityConfig;
use RedDevil\Core\DatabaseData;
use RedDevil\Core\Identity\Statements\TableCrudOps;
use ReflectionClass;
use ReflectionMethod;

class IdentityManager {

    public static function updateIdentity()
    {
        if (!IdentityConfig::UPDATE_IDENTITY) {
            return;
        }

        $columnsToAdd = new IdentityUserTable();
        $columnsToDelete = new IdentityUserTable();
        $columnsToUpdate = new IdentityUserTable();

        $databaseUser = self::getUserFromDatabase();
        $codeUser = self::getUserFromIdentitySystem();

        foreach ($codeUser->getColumns() as $name => $type) {
            if (!$databaseUser->hasColumn($name)) {
                $columnsToAdd->setColumn($name, $type);
            } else {
                if ($type !== $databaseUser->getColumnType($name)) {
                    $columnsToUpdate->setColumn($name, $type);
                }
            }
        }
        foreach ($databaseUser->getColumns() as $name => $type) {
            if (!$codeUser->hasColumn($name)) {
                if ($name == 'id' || $name == 'Id' || $name == 'password' || $name == 'passwordHash') {
                    continue;
                }

                $columnsToDelete->setColumn($name, $type);
            } else {
                if ($type !== $codeUser->getColumnType($name)) {
                    $columnsToUpdate->setColumn($name, $codeUser->getColumnType($name));
                }
            }
        }

        $tableOps = new TableCrudOps();
        foreach ($columnsToAdd->getColumns() as $column => $type) {
            $tableOps->addColumn('users', $column, $type);
        }
        foreach ($columnsToDelete->getColumns() as $column => $type) {
            $tableOps->dropColumn('users', $column);
        }
        foreach ($columnsToUpdate->getColumns() as $column => $type) {
            $tableOps->modifyColumn('users', $column, $type);
        }

        if (!$tableOps->tableExists('roles')) {
            self::createRolesTable();
        }
        if (!$tableOps->tableExists('users_roles')) {
            self::createUsersRolesTable();
        }
    }

    public static function createIdentity()
    {
        if (!IdentityConfig::UPDATE_IDENTITY) {
            return;
        }

        $tableOps = new TableCrudOps();
        if ($tableOps->tableExists('users')) {
            return;
        }

        $tableOps->dropTable('roles');
        $tableOps->dropTable('users_roles');

        $tableOps->createTable('users');
        $tableOps->addColumn('users', 'passwordHash', 'varchar(255)');

        $codeUser = self::getUserFromIdentitySystem();

        foreach ($codeUser->getColumns() as $column => $type) {
            $tableOps->addColumn('users', $column, $type);
        }

        self::createRolesTable();
        self::createUsersRolesTable();
    }

    private static function getUserFromDatabase()
    {
        $userTable = new IdentityUserTable();

        $db = DatabaseData::getInstance(DatabaseConfig::DB_INSTANCE);
        $statement = $db->query("show columns from users");
        $columns =
            array_map(function($c) {
                return [
                    'name' => $c['Field'],
                    'type' => $c['Type']
                ];
            },
                $statement->fetchAll());
        if (count($columns) == 0) {
            return null;
        }

        foreach ($columns as $column) {
            $userTable->setColumn($column['name'], $column['type']);
        }
        return $userTable;
    }
    
    private static function getUserFromIdentitySystem()
    {
        $userTable = new IdentityUserTable();

        $className = IdentityConfig::CURRENT_USER_MODEL;
        $userInstance = new $className();
        $class = new ReflectionClass($userInstance);
        $methods = $class->getMethods(ReflectionMethod::IS_PUBLIC);

        foreach ($methods as $method) {
            if (strpos($method->getName(), 'get') === 0) {
                $columnName = substr($method->getName(), 3, strlen($method->getName()));
                $columnName = strtolower($columnName);

                $annotationsText = $method->getDocComment();
                preg_match("/@type\s+([\w\d\(\)]+)/", $annotationsText, $matches);
                $type = $matches[1];

                $userTable->setColumn($columnName, $type);
            }
        }

        return $userTable;
    }

    private static function createRolesTable()
    {
        $tableOps = new TableCrudOps();
        $tableOps->createTable('roles');
        $tableOps->addColumn('roles', 'title', 'varchar(255)');
        foreach (IdentityConfig::$DEFAULT_USER_ROLES as $role) {
            $tableOps->insertRole($role);
        }
    }

    private static function createUsersRolesTable()
    {
        $tableOps = new TableCrudOps();
        $tableOps->createTable('users_roles');
        $tableOps->addColumn('users_roles', 'user_id', 'int(11)');
        $tableOps->addColumn('users_roles', 'role_id', 'int(11)');
    }
}