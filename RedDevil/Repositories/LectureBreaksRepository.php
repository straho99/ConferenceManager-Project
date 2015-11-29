<?php
namespace RedDevil\Repositories;

use RedDevil\Core\DatabaseData;
use RedDevil\Models\Lecturebreak;
use RedDevil\Collections\LecturebreakCollection;

class LecturebreaksRepository
{
    private $query;

    private $where = " WHERE 1";

    private $placeholders = [];

    private $order = '';

    private static $selectedObjectPool = [];
    private static $insertObjectPool = [];

    /**
     * @var LecturebreaksRepository
     */
    private static $inst = null;

    private function __construct() { }

    /**
     * @return LecturebreaksRepository
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
     * @param $LectureId
     * @return $this
     */
    public function filterByLectureId($LectureId)
    {
        $this->where .= " AND LectureId $LectureId";
        $this->placeholders[] = $LectureId;

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
     * @return LecturebreakCollection
     * @throws \Exception
     */
    public function findAll()
    {
        $db = DatabaseData::getInstance(\RedDevil\Config\DatabaseConfig::DB_INSTANCE);

        $this->query = "SELECT * FROM lecturebreaks" . $this->where . $this->order;
        $result = $db->prepare($this->query);
        $result->execute([]);

        $collection = [];
        foreach ($result->fetchAll() as $entityInfo) {
            $entity = new Lecturebreak($entityInfo['Title'],
$entityInfo['Description'],
$entityInfo['LectureId'],
$entityInfo['StartDate'],
$entityInfo['EndDate'],
$entityInfo['id']);

            $collection[] = $entity;
            self::$selectedObjectPool[] = $entity;
        }

        $this->where = substr($this->where, 0, 8);
        return new LecturebreakCollection($collection);
    }

    /**
     * @return Lecturebreak
     * @throws \Exception
     */
    public function findOne()
    {
        $db = DatabaseData::getInstance(\RedDevil\Config\DatabaseConfig::DB_INSTANCE);

        $this->query = "SELECT * FROM lecturebreaks" . $this->where . $this->order . " LIMIT 1";
        $result = $db->prepare($this->query);
        $result->execute([]);
        $entityInfo = $result->fetch();
        $entity = new Lecturebreak($entityInfo['Title'],
$entityInfo['Description'],
$entityInfo['LectureId'],
$entityInfo['StartDate'],
$entityInfo['EndDate'],
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

        $this->query = "DELETE FROM lecturebreaks" . $this->where;
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);

        return $result->rowCount() > 0;
    }

    public static function add(Lecturebreak $model)
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

    private static function update(Lecturebreak $model)
    {
        $db = DatabaseData::getInstance(\RedDevil\Config\DatabaseConfig::DB_INSTANCE);

        $query = "UPDATE lecturebreaks SET Title= :Title, Description= :Description, LectureId= :LectureId, StartDate= :StartDate, EndDate= :EndDate WHERE id = :id";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':id' => $model->getId(),
':Title' => $model->getTitle(),
':Description' => $model->getDescription(),
':LectureId' => $model->getLectureId(),
':StartDate' => $model->getStartDate(),
':EndDate' => $model->getEndDate()
            ]
        );
    }

    private static function insert(Lecturebreak $model)
    {
        $db = DatabaseData::getInstance(\RedDevil\Config\DatabaseConfig::DB_INSTANCE);

        $query = "INSERT INTO lecturebreaks (Title,Description,LectureId,StartDate,EndDate) VALUES (:Title, :Description, :LectureId, :StartDate, :EndDate);";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':Title' => $model->getTitle(),
':Description' => $model->getDescription(),
':LectureId' => $model->getLectureId(),
':StartDate' => $model->getStartDate(),
':EndDate' => $model->getEndDate()
            ]
        );
        $model->setId($db->lastInsertId());
    }

    private function isColumnAllowed($column)
    {
        $refc = new \ReflectionClass('\RedDevil\Models\Lecturebreak');
        $consts = $refc->getConstants();

        return in_array($column, $consts);
    }
}