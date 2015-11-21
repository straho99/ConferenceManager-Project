<?php
namespace RedDevil\Repositories;

use RedDevil\Config\AppConfig;
use RedDevil\Core\DatabaseData;
use RedDevil\Models\Lecture;
use RedDevil\Collections\LectureCollection;

class LecturesRepository
{
    private $query;

    private $where = " WHERE 1";

    private $placeholders = [];

    private $order = '';

    private static $selectedObjectPool = [];
    private static $insertObjectPool = [];

    /**
     * @var LecturesRepository
     */
    private static $inst = null;

    private function __construct() { }

    /**
     * @return LecturesRepository
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
     * @param $Title
     * @return $this
     */
    public function filterByTitle($Title)
    {
        $this->where .= " AND Title $Title";
        $this->placeholders[] = $Title;

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
     * @param $Hall_Id
     * @return $this
     */
    public function filterByHall_Id($Hall_Id)
    {
        $this->where .= " AND Hall_Id $Hall_Id";
        $this->placeholders[] = $Hall_Id;

        return $this;
    }
    /**
     * @param $Speaker_Id
     * @return $this
     */
    public function filterBySpeaker_Id($Speaker_Id)
    {
        $this->where .= " AND Speaker_Id $Speaker_Id";
        $this->placeholders[] = $Speaker_Id;

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
     * @return LectureCollection
     * @throws \Exception
     */
    public function findAll()
    {
        $db = DatabaseData::getInstance(\RedDevil\Config\DatabaseConfig::DB_INSTANCE);

        $this->query = "SELECT * FROM lectures" . $this->where . $this->order;
        $result = $db->prepare($this->query);
        $result->execute([]);

        $collection = [];
        foreach ($result->fetchAll() as $entityInfo) {
            $entity = new Lecture($entityInfo['Title'],
$entityInfo['Description'],
$entityInfo['StartDate'],
$entityInfo['EndDate'],
$entityInfo['ConferenceId'],
$entityInfo['Hall_Id'],
$entityInfo['Speaker_Id'],
$entityInfo['id']);

            $collection[] = $entity;
            self::$selectedObjectPool[] = $entity;
        }

        $this->where = substr($this->where, 0, 8);
        return new LectureCollection($collection);
    }

    /**
     * @return Lecture
     * @throws \Exception
     */
    public function findOne()
    {
        $db = DatabaseData::getInstance(\RedDevil\Config\DatabaseConfig::DB_INSTANCE);

        $this->query = "SELECT * FROM lectures" . $this->where . $this->order . " LIMIT 1";
        $result = $db->prepare($this->query);
        $result->execute([]);
        $entityInfo = $result->fetch();
        $entity = new Lecture($entityInfo['Title'],
$entityInfo['Description'],
$entityInfo['StartDate'],
$entityInfo['EndDate'],
$entityInfo['ConferenceId'],
$entityInfo['Hall_Id'],
$entityInfo['Speaker_Id'],
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

        $this->query = "DELETE FROM lectures" . $this->where;
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);

        return $result->rowCount() > 0;
    }

    public static function add(Lecture $model)
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

    private static function update(Lecture $model)
    {
        $db = DatabaseData::getInstance(\RedDevil\Config\DatabaseConfig::DB_INSTANCE);

        $query = "UPDATE lectures SET Title= :Title, Description= :Description, StartDate= :StartDate, EndDate= :EndDate, ConferenceId= :ConferenceId, Hall_Id= :Hall_Id, Speaker_Id= :Speaker_Id WHERE id = :id";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':id' => $model->getId(),
':Title' => $model->getTitle(),
':Description' => $model->getDescription(),
':StartDate' => $model->getStartDate(),
':EndDate' => $model->getEndDate(),
':ConferenceId' => $model->getConferenceId(),
':Hall_Id' => $model->getHall_Id(),
':Speaker_Id' => $model->getSpeaker_Id()
            ]
        );
    }

    private static function insert(Lecture $model)
    {
        $db = DatabaseData::getInstance(\RedDevil\Config\DatabaseConfig::DB_INSTANCE);

        $query = "INSERT INTO lectures (Title,Description,StartDate,EndDate,ConferenceId,Hall_Id,Speaker_Id) VALUES (:Title, :Description, :StartDate, :EndDate, :ConferenceId, :Hall_Id, :Speaker_Id);";

        $result = $db->prepare($query);
        $result->execute(
            [
                ':Title' => $model->getTitle(),
':Description' => $model->getDescription(),
':StartDate' => $model->getStartDate(),
':EndDate' => $model->getEndDate(),
':ConferenceId' => $model->getConferenceId(),
':Hall_Id' => $model->getHall_Id(),
':Speaker_Id' => $model->getSpeaker_Id()
            ]
        );
        $model->setId($db->lastInsertId());
    }

    private function isColumnAllowed($column)
    {
        $refc = new \ReflectionClass('\RedDevil\Models\Lecture');
        $consts = $refc->getConstants();

        return in_array($column, $consts);
    }
}