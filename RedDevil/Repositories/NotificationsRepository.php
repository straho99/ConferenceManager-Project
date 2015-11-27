<?php
namespace RedDevil\Repositories;

use RedDevil\Core\DatabaseData;
use RedDevil\Models\Notification;
use RedDevil\Collections\NotificationCollection;

class NotificationsRepository
{
    private $query;

    private $where = " WHERE 1";

    private $placeholders = [];

    private $order = '';

    private static $selectedObjectPool = [];
    private static $insertObjectPool = [];

    /**
     * @var NotificationsRepository
     */
    private static $inst = null;

    private function __construct() { }

    /**
     * @return NotificationsRepository
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
     * @param $Content
     * @return $this
     */
    public function filterByContent($Content)
    {
        $this->where .= " AND Content $Content";
        $this->placeholders[] = $Content;

        return $this;
    }
    /**
     * @param $UserId
     * @return $this
     */
    public function filterByUserId($UserId)
    {
        $this->where .= " AND UserId $UserId";
        $this->placeholders[] = $UserId;

        return $this;
    }
    /**
     * @param $IsRead
     * @return $this
     */
    public function filterByIsRead($IsRead)
    {
        $this->where .= " AND IsRead $IsRead";
        $this->placeholders[] = $IsRead;

        return $this;
    }
    /**
     * @param $CreatedOn
     * @return $this
     */
    public function filterByCreatedOn($CreatedOn)
    {
        $this->where .= " AND CreatedOn $CreatedOn";
        $this->placeholders[] = $CreatedOn;

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
     * @return NotificationCollection
     * @throws \Exception
     */
    public function findAll()
    {
        $db = DatabaseData::getInstance(\RedDevil\Config\DatabaseConfig::DB_INSTANCE);

        $this->query = "SELECT * FROM notifications" . $this->where . $this->order;
        $result = $db->prepare($this->query);
        $result->execute([]);

        $collection = [];
        foreach ($result->fetchAll() as $entityInfo) {
            $entity = new Notification($entityInfo['Content'],
$entityInfo['UserId'],
$entityInfo['IsRead'],
$entityInfo['CreatedOn'],
$entityInfo['id']);

            $collection[] = $entity;
            self::$selectedObjectPool[] = $entity;
        }

        $this->where = substr($this->where, 0, 8);
        return new NotificationCollection($collection);
    }

    /**
     * @return Notification
     * @throws \Exception
     */
    public function findOne()
    {
        $db = DatabaseData::getInstance(\RedDevil\Config\DatabaseConfig::DB_INSTANCE);

        $this->query = "SELECT * FROM notifications" . $this->where . $this->order . " LIMIT 1";
        $result = $db->prepare($this->query);
        $result->execute([]);
        $entityInfo = $result->fetch();
        $entity = new Notification($entityInfo['Content'],
$entityInfo['UserId'],
$entityInfo['IsRead'],
$entityInfo['CreatedOn'],
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

        $this->query = "DELETE FROM notifications" . $this->where;
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);

        return $result->rowCount() > 0;
    }

    public static function add(Notification $model)
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

    private static function update(Notification $model)
    {
        $db = DatabaseData::getInstance(\RedDevil\Config\DatabaseConfig::DB_INSTANCE);

        $query = "UPDATE notifications SET Content= :Content, UserId= :UserId, IsRead= :IsRead, CreatedOn= :CreatedOn WHERE id = :id";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':id' => $model->getId(),
':Content' => $model->getContent(),
':UserId' => $model->getUserId(),
':IsRead' => $model->getIsRead(),
':CreatedOn' => $model->getCreatedOn()
            ]
        );
    }

    private static function insert(Notification $model)
    {
        $db = DatabaseData::getInstance(\RedDevil\Config\DatabaseConfig::DB_INSTANCE);

        $query = "INSERT INTO notifications (Content,UserId,IsRead,CreatedOn) VALUES (:Content, :UserId, :IsRead, :CreatedOn);";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':Content' => $model->getContent(),
':UserId' => $model->getUserId(),
':IsRead' => $model->getIsRead(),
':CreatedOn' => $model->getCreatedOn()
            ]
        );
        $model->setId($db->lastInsertId());
    }

    private function isColumnAllowed($column)
    {
        $refc = new \ReflectionClass('\RedDevil\Models\Notification');
        $consts = $refc->getConstants();

        return in_array($column, $consts);
    }
}