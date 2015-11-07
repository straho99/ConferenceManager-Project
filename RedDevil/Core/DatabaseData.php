<?php

namespace RedDevil\Core;

class DatabaseData {
    private static $instances;
    private $db;

    private function __construct(\PDO $pdo) {
        $this->db = $pdo;
    }

    /**
     * @param string $instanceName
     * @return DatabaseData
     * @throws \Exception
     */
    public static function getInstance($instanceName = 'default') {
        if (!isset(self::$instances[$instanceName])) {
            throw new \Exception('Instance with that name was not set.');
        }

        return self::$instances[$instanceName];
    }

    public static function setInstance($instanceName, $driver, $user, $pass, $dbName, $host = null) {
        $driver = \RedDevil\Core\DriverFactory::create($driver, $user, $pass, $dbName, $host);

        $pdo = new \PDO($driver->getDsn(), $user, $pass);

        self::$instances[$instanceName] = new self($pdo);
    }

    public function prepare($statement, $driver_options = [])
    {
        $pdoStatement = $this->db->prepare($statement, $driver_options);
        return new Statement($pdoStatement);
    }

    public function query($statement)
    {
        return $this->db->query($statement);
    }

    public function lastInsertId($name = null)
    {
        return $this->db->lastInsertId($name);
    }
}

class Statement {
    private $statement;

    public function __construct(\PDOStatement $stmnt)
    {
        $this->statement = $stmnt;
    }

    public function fetch($fetchStyle = \PDO::FETCH_ASSOC)
    {
        return $this->statement->fetch($fetchStyle);
    }

    public function fetchAll($fetchStyle = \PDO::FETCH_ASSOC)
    {
        return $this->statement->fetchAll($fetchStyle);
    }

    public function bindParam($parameter, &$variable, $dataType = \PDO::PARAM_STR, $length = null, $driver_options = [])
    {
        return $this->statement->bindParam($parameter, $variable, $dataType, $length, $driver_options);
    }

    public function execute($input_parameters = [])
    {
        return $this->statement->execute($input_parameters);
    }

    public function rowCount()
    {
        return $this->statement->rowCount();
    }
}