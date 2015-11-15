<?php
namespace RedDevil\Repositories;

use RedDevil\Core\DatabaseData;
use RedDevil\Models\Venue;
use RedDevil\Collections\VenueCollection;

class VenuesRepository
{
    private $query;

    private $where = " WHERE 1";

    private $placeholders = [];

    private $order = '';

    private static $selectedObjectPool = [];
    private static $insertObjectPool = [];

    /**
     * @var VenuesRepository
     */
    private static $inst = null;

    private function __construct() { }

    /**
     * @return VenuesRepository
     */
    public static function create()
    {
        if (self::$inst == null) {
            self::$inst = new self();
        }

        return self::$inst;
    }

    /**
     * @param $Id
     * @return $this
     */
    public function filterById($Id)
    {
        $this->where .= " AND Id $Id";
        $this->placeholders[] = $Id;

        return $this;
    }
    /**
     * @param $Name
     * @return $this
     */
    public function filterByName($Name)
    {
        $this->where .= " AND Name $Name";
        $this->placeholders[] = $Name;

        return $this;
    }
    /**
     * @param $Description
     * @return $this
     */
    public function filterByDescription($Description)
    {
        $this->where .= " AND Description $Description";
        $this->placeholders[] = $Description;

        return $this;
    }
    /**
     * @param $Address
     * @return $this
     */
    public function filterByAddress($Address)
    {
        $this->where .= " AND Address $Address";
        $this->placeholders[] = $Address;

        return $this;
    }
    /**
     * @param $OwnerId
     * @return $this
     */
    public function filterByOwnerId($OwnerId)
    {
        $this->where .= " AND OwnerId $OwnerId";
        $this->placeholders[] = $OwnerId;

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
     * @return VenueCollection
     * @throws \Exception
     */
    public function findAll()
    {
        $db = DatabaseData::getInstance(\RedDevil\Config\DatabaseConfig::DB_INSTANCE);

        $this->query = "SELECT * FROM venues" . $this->where . $this->order;
        $result = $db->prepare($this->query);
        $result->execute([]);

        $collection = [];
        foreach ($result->fetchAll() as $entityInfo) {
            $entity = new Venue($entityInfo['Id'],
$entityInfo['Name'],
$entityInfo['Description'],
$entityInfo['Address'],
$entityInfo['OwnerId']);

            $collection[] = $entity;
            self::$selectedObjectPool[] = $entity;
        }

        return new VenueCollection($collection);
    }

    /**
     * @return Venue
     * @throws \Exception
     */
    public function findOne()
    {
        $db = DatabaseData::getInstance(\RedDevil\Config\DatabaseConfig::DB_INSTANCE);

        $this->query = "SELECT * FROM venues" . $this->where . $this->order . " LIMIT 1";
        $result = $db->prepare($this->query);
        $result->execute([]);
        $entityInfo = $result->fetch();
        $entity = new Venue($entityInfo['Id'],
$entityInfo['Name'],
$entityInfo['Description'],
$entityInfo['Address'],
$entityInfo['OwnerId']);

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

        $this->query = "DELETE FROM venues" . $this->where;
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);

        return $result->rowCount() > 0;
    }

    public static function add(Venue $model)
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

    private static function update(Venue $model)
    {
        $db = DatabaseData::getInstance(\RedDevil\Config\DatabaseConfig::DB_INSTANCE);

        $query = "UPDATE venues SET Id= :Id, Name= :Name, Description= :Description, Address= :Address, OwnerId= :OwnerId WHERE id = :id";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':Id' => $model->getId(),
':Name' => $model->getName(),
':Description' => $model->getDescription(),
':Address' => $model->getAddress(),
':OwnerId' => $model->getOwnerId()
            ]
        );
    }

    private static function insert(Venue $model)
    {
        $db = DatabaseData::getInstance(\RedDevil\Config\DatabaseConfig::DB_INSTANCE);

        $query = "INSERT INTO users (Id,Name,Description,Address,OwnerId) VALUES (:Id, :Name, :Description, :Address, :OwnerId);";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':Id' => $model->getId(),
':Name' => $model->getName(),
':Description' => $model->getDescription(),
':Address' => $model->getAddress(),
':OwnerId' => $model->getOwnerId()
            ]
        );
        $model->setId($db->lastInsertId());
    }

    private function isColumnAllowed($column)
    {
        $refc = new \ReflectionClass('\RedDevil\Models\Venue');
        $consts = $refc->getConstants();

        return in_array($column, $consts);
    }
}