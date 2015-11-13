<?php

namespace RedDevil\Core\Identity;

use RedDevil\Config\DatabaseConfig;
use RedDevil\Config\IdentityConfig;
use RedDevil\Core\DatabaseData;
use ReflectionClass;
use ReflectionMethod;

class IdentityManager {
    public static function updateIdentity()
    {
        if (!IdentityConfig::UPDATE_IDENTITY) {
            return;
        }

        $databaseUser = self::getUserFromDatabase();
        $codeUser = self::getUserFromIdentitySystem();

        var_dump($databaseUser, $codeUser);

        var_dump($databaseUser->equals($codeUser));
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
}