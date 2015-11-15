<?php
namespace RedDevil\Repositories;

use RedDevil\Core\DatabaseData;
use RedDevil\Models\LectureBreak;
use RedDevil\Collections\LectureBreakCollection;

class LectureBreaksRepository
{
    private $query;

    private $where = " WHERE 1";

    private $placeholders = [];

    private $order = '';

    private static $selectedObjectPool = [];
    private static $insertObjectPool = [];

    /**
     * @var LectureBreaksRepository
     */
    private static $inst = null;

    private function __construct() { }

    /**
     * @return LectureBreaksRepository
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
     * @return LectureBreakCollection
     * @throws \Exception
     */
    public function findAll()
    {
        $db = DatabaseData::getInstance(\RedDevil\Config\DatabaseConfig::DB_INSTANCE);

        $this->query = "SELECT * FROM lectureBreaks" . $this->where . $this->order;
        $result = $db->prepare($this->query);
        $result->execute([]);

        $collection = [];
        foreach ($result->fetchAll() as $entityInfo) {
            $entity = new LectureBreak($entityInfo['Id'],
$entityInfo['Title'],
$entityInfo['Description'],
$entityInfo['LectureId']);

            $collection[] = $entity;
            self::$selectedObjectPool[] = $entity;
        }

        $this->where = substr($this->where, 0, 8);
        return new LectureBreakCollection($collection);
    }

    /**
     * @return LectureBreak
     * @throws \Exception
     */
    public function findOne()
    {
        $db = DatabaseData::getInstance(\RedDevil\Config\DatabaseConfig::DB_INSTANCE);

        $this->query = "SELECT * FROM lectureBreaks" . $this->where . $this->order . " LIMIT 1";
        $result = $db->prepare($this->query);
        $result->execute([]);
        $entityInfo = $result->fetch();
        $entity = new LectureBreak($entityInfo['Id'],
$entityInfo['Title'],
$entityInfo['Description'],
$entityInfo['LectureId']);

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

        $this->query = "DELETE FROM lectureBreaks" . $this->where;
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);

        return $result->rowCount() > 0;
    }

    public static function add(LectureBreak $model)
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

    private static function update(LectureBreak $model)
    {
        $db = DatabaseData::getInstance(\RedDevil\Config\DatabaseConfig::DB_INSTANCE);

        $query = "UPDATE lectureBreaks SET Id= :Id, Title= :Title, Description= :Description, LectureId= :LectureId WHERE id = :id";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':Id' => $model->getId(),
':Title' => $model->getTitle(),
':Description' => $model->getDescription(),
':LectureId' => $model->getLectureId()
            ]
        );
    }

    private static function insert(LectureBreak $model)
    {
        $db = DatabaseData::getInstance(\RedDevil\Config\DatabaseConfig::DB_INSTANCE);

        $query = "INSERT INTO users (Id,Title,Description,LectureId) VALUES (:Id, :Title, :Description, :LectureId);";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':Id' => $model->getId(),
':Title' => $model->getTitle(),
':Description' => $model->getDescription(),
':LectureId' => $model->getLectureId()
            ]
        );
        $model->setId($db->lastInsertId());
    }

    private function isColumnAllowed($column)
    {
        $refc = new \ReflectionClass('\RedDevil\Models\LectureBreak');
        $consts = $refc->getConstants();

        return in_array($column, $consts);
    }
}