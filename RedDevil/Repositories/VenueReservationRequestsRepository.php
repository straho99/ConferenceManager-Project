<?php
namespace RedDevil\Repositories;

use RedDevil\Core\DatabaseData;
use RedDevil\Models\Venuereservationrequest;
use RedDevil\Collections\VenuereservationrequestCollection;

class VenuereservationrequestsRepository
{
    private $query;

    private $where = " WHERE 1";

    private $placeholders = [];

    private $order = '';

    private static $selectedObjectPool = [];
    private static $insertObjectPool = [];

    /**
     * @var VenuereservationrequestsRepository
     */
    private static $inst = null;

    private function __construct() { }

    /**
     * @return VenuereservationrequestsRepository
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
        $this->where .= " AND id $id";
        $this->placeholders[] = $id;

        return $this;
    }
    /**
     * @param $VenueId
     * @return $this
     */
    public function filterByVenueId($VenueId)
    {
        $this->where .= " AND VenueId $VenueId";
        $this->placeholders[] = $VenueId;

        return $this;
    }
    /**
     * @param $ConferenceId
     * @return $this
     */
    public function filterByConferenceId($ConferenceId)
    {
        $this->where .= " AND ConferenceId $ConferenceId";
        $this->placeholders[] = $ConferenceId;

        return $this;
    }
    /**
     * @param $Status
     * @return $this
     */
    public function filterByStatus($Status)
    {
        $this->where .= " AND Status $Status";
        $this->placeholders[] = $Status;

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
     * @return VenuereservationrequestCollection
     * @throws \Exception
     */
    public function findAll()
    {
        $db = DatabaseData::getInstance(\RedDevil\Config\DatabaseConfig::DB_INSTANCE);

        $this->query = "SELECT * FROM venuereservationrequests" . $this->where . $this->order;
        $result = $db->prepare($this->query);
        $result->execute([]);

        $collection = [];
        foreach ($result->fetchAll() as $entityInfo) {
            $entity = new Venuereservationrequest($entityInfo['VenueId'],
$entityInfo['ConferenceId'],
$entityInfo['Status'],
$entityInfo['id']);

            $collection[] = $entity;
            self::$selectedObjectPool[] = $entity;
        }

        $this->where = substr($this->where, 0, 8);
        return new VenuereservationrequestCollection($collection);
    }

    /**
     * @return Venuereservationrequest
     * @throws \Exception
     */
    public function findOne()
    {
        $db = DatabaseData::getInstance(\RedDevil\Config\DatabaseConfig::DB_INSTANCE);

        $this->query = "SELECT * FROM venuereservationrequests" . $this->where . $this->order . " LIMIT 1";
        $result = $db->prepare($this->query);
        $result->execute([]);
        $entityInfo = $result->fetch();
        $entity = new Venuereservationrequest($entityInfo['VenueId'],
$entityInfo['ConferenceId'],
$entityInfo['Status'],
$entityInfo['id']);

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

        $this->query = "DELETE FROM venuereservationrequests" . $this->where;
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);

        return $result->rowCount() > 0;
    }

    public static function add(Venuereservationrequest $model)
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

        self::$insertObjectPool = [];

        return true;
    }

    private static function update(Venuereservationrequest $model)
    {
        $db = DatabaseData::getInstance(\RedDevil\Config\DatabaseConfig::DB_INSTANCE);

        $query = "UPDATE venuereservationrequests SET VenueId= :VenueId, ConferenceId= :ConferenceId, Status= :Status WHERE id = :id";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':id' => $model->getId(),
':VenueId' => $model->getVenueId(),
':ConferenceId' => $model->getConferenceId(),
':Status' => $model->getStatus()
            ]
        );
    }

    private static function insert(Venuereservationrequest $model)
    {
        $db = DatabaseData::getInstance(\RedDevil\Config\DatabaseConfig::DB_INSTANCE);

        $query = "INSERT INTO venuereservationrequests (VenueId,ConferenceId,Status) VALUES (:VenueId, :ConferenceId, :Status);";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':VenueId' => $model->getVenueId(),
':ConferenceId' => $model->getConferenceId(),
':Status' => $model->getStatus()
            ]
        );
        $model->setId($db->lastInsertId());
    }

    private function isColumnAllowed($column)
    {
        $refc = new \ReflectionClass('\RedDevil\Models\Venuereservationrequest');
        $consts = $refc->getConstants();

        return in_array($column, $consts);
    }
}