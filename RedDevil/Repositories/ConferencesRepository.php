<?php
namespace RedDevil\Repositories;

use RedDevil\Core\DatabaseData;
use RedDevil\Models\Conference;
use RedDevil\Collections\ConferenceCollection;

class ConferencesRepository
{
    private $query;

    private $where = " WHERE 1";

    private $placeholders = [];

    private $order = '';

    private static $selectedObjectPool = [];
    private static $insertObjectPool = [];

    /**
     * @var ConferencesRepository
     */
    private static $inst = null;

    private function __construct() { }

    /**
     * @return ConferencesRepository
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
     * @param $StartDate
     * @return $this
     */
    public function filterByStartDate($StartDate)
    {
        $this->where .= " AND StartDate $StartDate";
        $this->placeholders[] = $StartDate;

        return $this;
    }
    /**
     * @param $EndDate
     * @return $this
     */
    public function filterByEndDate($EndDate)
    {
        $this->where .= " AND EndDate $EndDate";
        $this->placeholders[] = $EndDate;

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
     * @param $Venue_Id
     * @return $this
     */
    public function filterByVenue_Id($Venue_Id)
    {
        $this->where .= " AND Venue_Id $Venue_Id";
        $this->placeholders[] = $Venue_Id;

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
     * @return ConferenceCollection
     * @throws \Exception
     */
    public function findAll()
    {
        $db = DatabaseData::getInstance(\RedDevil\Config\DatabaseConfig::DB_INSTANCE);

        $this->query = "SELECT * FROM conferences" . $this->where . $this->order;
        $result = $db->prepare($this->query);
        $result->execute([]);

        $collection = [];
        foreach ($result->fetchAll() as $entityInfo) {
            $entity = new Conference($entityInfo['Id'],
$entityInfo['Name'],
$entityInfo['StartDate'],
$entityInfo['EndDate'],
$entityInfo['OwnerId'],
$entityInfo['Venue_Id']);

            $collection[] = $entity;
            self::$selectedObjectPool[] = $entity;
        }

        $this->where = substr($this->where, 0, 8);
        return new ConferenceCollection($collection);
    }

    /**
     * @return Conference
     * @throws \Exception
     */
    public function findOne()
    {
        $db = DatabaseData::getInstance(\RedDevil\Config\DatabaseConfig::DB_INSTANCE);

        $this->query = "SELECT * FROM conferences" . $this->where . $this->order . " LIMIT 1";
        $result = $db->prepare($this->query);
        $result->execute([]);
        $entityInfo = $result->fetch();
        $entity = new Conference($entityInfo['Id'],
$entityInfo['Name'],
$entityInfo['StartDate'],
$entityInfo['EndDate'],
$entityInfo['OwnerId'],
$entityInfo['Venue_Id']);

        self::$selectedObjectPool[] = $entity;

        $this->where = substr($this->where, 0, 8);
        return $entity;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function delete()
    {
        $db = DatabaseData::getInstance(\RedDevil\Config\DatabaseConfig::DB_INSTANCE);

        $this->query = "DELETE FROM conferences" . $this->where;
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);

        return $result->rowCount() > 0;
    }

    public static function add(Conference $model)
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

    private static function update(Conference $model)
    {
        $db = DatabaseData::getInstance(\RedDevil\Config\DatabaseConfig::DB_INSTANCE);

        $query = "UPDATE conferences SET Id= :Id, Name= :Name, StartDate= :StartDate, EndDate= :EndDate, OwnerId= :OwnerId, Venue_Id= :Venue_Id WHERE id = :id";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':Id' => $model->getId(),
':Name' => $model->getName(),
':StartDate' => $model->getStartDate(),
':EndDate' => $model->getEndDate(),
':OwnerId' => $model->getOwnerId(),
':Venue_Id' => $model->getVenue_Id()
            ]
        );
    }

    private static function insert(Conference $model)
    {
        $db = DatabaseData::getInstance(\RedDevil\Config\DatabaseConfig::DB_INSTANCE);

        $query = "INSERT INTO users (Id,Name,StartDate,EndDate,OwnerId,Venue_Id) VALUES (:Id, :Name, :StartDate, :EndDate, :OwnerId, :Venue_Id);";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':Id' => $model->getId(),
':Name' => $model->getName(),
':StartDate' => $model->getStartDate(),
':EndDate' => $model->getEndDate(),
':OwnerId' => $model->getOwnerId(),
':Venue_Id' => $model->getVenue_Id()
            ]
        );
        $model->setId($db->lastInsertId());
    }

    private function isColumnAllowed($column)
    {
        $refc = new \ReflectionClass('\RedDevil\Models\Conference');
        $consts = $refc->getConstants();

        return in_array($column, $consts);
    }
}