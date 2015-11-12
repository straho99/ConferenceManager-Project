<?php
namespace RedDevil\Repositories;

use RedDevil\Core\DatabaseData;
use RedDevil\Models\User;
use RedDevil\Collections\UserCollection;

class UsersRepository
{
    private $query;

    private $where = " WHERE 1";

    private $placeholders = [];

    private $order = '';

    private static $selectedObjectPool = [];
    private static $insertObjectPool = [];

    /**
     * @var UsersRepository
     */
    private static $inst = null;

    private function __construct() { }

    /**
     * @return UsersRepository
     */
    public static function create()
    {
        if (self::$inst == null) {
            self::$inst = new self();
        }

        return self::$inst;
    }

    /**
     * @param $id
     * @return $this
     */
    public function filterById($id)
    {
        $this->where .= " AND id = ?";
        $this->placeholders[] = $id;

        return $this;
    }
    /**
     * @param $username
     * @return $this
     */
    public function filterByUsername($username)
    {
        $this->where .= " AND username = ?";
        $this->placeholders[] = $username;

        return $this;
    }
    /**
     * @param $password
     * @return $this
     */
    public function filterByPassword($password)
    {
        $this->where .= " AND password = ?";
        $this->placeholders[] = $password;

        return $this;
    }
    /**
     * @param $role_id
     * @return $this
     */
    public function filterByRole_id($role_id)
    {
        $this->where .= " AND role_id = ?";
        $this->placeholders[] = $role_id;

        return $this;
    }

    /**
     * @param $column
     * @return $this
     * @throws \Exception
     */
    public function orderBy($column)
    {
        if (!$this->isColumnAllowed($column)) {
            throw new \Exception("Column not found");
        }

        if (!empty($this->order)) {
            throw new \Exception("Cannot do primary order, because you already have a primary order");
        }

        $this->order .= " ORDER BY $column";

        return $this;
    }

    /**
     * @param $column
     * @return $this
     * @throws \Exception
     */
    public function orderByDescending($column)
    {
        if (!$this->isColumnAllowed($column)) {
            throw new \Exception("Column not found");
        }

        if (!empty($this->order)) {
            throw new \Exception("Cannot do primary order, because you already have a primary order");
        }

        $this->order .= " ORDER BY $column DESC";

        return $this;
    }

    /**
     * @param $column
     * @return $this
     * @throws \Exception
     */
    public function thenBy($column)
    {
        if (empty($this->order)) {
            throw new \Exception("Cannot do secondary order, because you don't have a primary order");
        }

        if (!$this->isColumnAllowed($column)) {
            throw new \Exception("Column not found");
        }

        $this->order .= ", $column ASC";

        return $this;
    }

    /**
     * @param $column
     * @return $this
     * @throws \Exception
     */
    public function thenByDescending($column)
    {
        if (empty($this->order)) {
            throw new \Exception("Cannot do secondary order, because you don't have a primary order");
        }

        if (!$this->isColumnAllowed($column)) {
            throw new \Exception("Column not found");
        }

        $this->order .= ", $column DESC";

        return $this;
    }

    /**
     * @return UserCollection
     * @throws \Exception
     */
    public function findAll()
    {
        $db = DatabaseData::getInstance(\RedDevil\Config\DatabaseConfig::DB_INSTANCE);

        $this->query = "SELECT * FROM users" . $this->where . $this->order;
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);

        $collection = [];
        foreach ($result->fetchAll() as $entityInfo) {
            $entity = new User($entityInfo['username'],
$entityInfo['password'],
$entityInfo['role_id'],
$entityInfo['id']);

            $collection[] = $entity;
            self::$selectedObjectPool[] = $entity;
        }

        return new UserCollection($collection);
    }

    /**
     * @return User
     * @throws \Exception
     */
    public function findOne()
    {
        $db = DatabaseData::getInstance(\RedDevil\Config\DatabaseConfig::DB_INSTANCE);

        $this->query = "SELECT * FROM users" . $this->where . $this->order . " LIMIT 1";
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);
        $entityInfo = $result->fetch();
        $entity = new User($entityInfo['username'],
$entityInfo['password'],
$entityInfo['role_id'],
$entityInfo['id']);

        self::$selectedObjectPool[] = $entity;

        return $entity;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function delete()
    {
        $db = DatabaseData::getInstance(\RedDevil\Config\DatabaseConfig::DB_INSTANCE);

        $this->query = "DELETE FROM users" . $this->where;
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);

        return $result->rowCount() > 0;
    }

    public static function add(User $model)
    {
        if ($model->getId()) {
            throw new \Exception('This entity is not new');
        }

        self::$insertObjectPool[] = $model;
    }

    public static function save()
    {
        foreach (self::$selectedObjectPool as $entity) {
            self::update($entity);
        }

        foreach (self::$insertObjectPool as $entity) {
            self::insert($entity);
        }

        return true;
    }

    private static function update(User $model)
    {
        $db = DatabaseData::getInstance(\RedDevil\Config\DatabaseConfig::DB_INSTANCE);

        $query = "UPDATE users SET username= :username, password= :password, role_id= :role_id WHERE id = :id";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':id' => $model->getId(),
':username' => $model->getUsername(),
':password' => $model->getPassword(),
':role_id' => $model->getRole_id()
            ]
        );
    }

    private static function insert(User $model)
    {
        $db = DatabaseData::getInstance(\RedDevil\Config\DatabaseConfig::DB_INSTANCE);

        $query = "INSERT INTO users (username,password,role_id) VALUES (:username, :password, :role_id);";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':username' => $model->getUsername(),
':password' => $model->getPassword(),
':role_id' => $model->getRole_id()
            ]
        );
        $model->setId($db->lastId());
    }

    private function isColumnAllowed($column)
    {
        $refc = new \ReflectionClass('\RedDevil\User');
        $consts = $refc->getConstants();

        return in_array($column, $consts);
    }
}