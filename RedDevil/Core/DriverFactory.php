<?php

namespace RedDevil\Core;

class DriverFactory {
    /**
     * @param $driver
     * @param $user
     * @param $pass
     * @param $dbName
     * @param $host
     * @return MySQLDriver
     */
    public static function create($driver, $user, $pass, $dbName, $host)
    {
        $driverName = strtolower($driver);
        switch ($driverName) {
            case 'mysql':
                $mySQLDriver = new MySQLDriver($user, $pass, $dbName, $host);
                return $mySQLDriver;
            default :
                $mySQLDriver = new MySQLDriver($user, $pass, $dbName, $host);
                return $mySQLDriver;
        }
    }
}