<?php
namespace RedDevil\Repositories;

use RedDevil\Core\DatabaseData;
use RedDevil\Models\Message;
use RedDevil\Collections\MessageCollection;

class MessagesRepository
{
    private $query;

    private $where = " WHERE 1";

    private $placeholders = [];

    private $order = '';

    private static $selectedObjectPool = [];
    private static $insertObjectPool = [];

    /**
     * @var MessagesRepository
     */
    private static $inst = null;

    private function __construct() { }

    /**
     * @return MessagesRepository
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
     * @param $SenderId
     * @return $this
     */
    public function filterBySenderId($SenderId)
    {
        $this->where .= " AND SenderId $SenderId";
        $this->placeholders[] = $SenderId;

        return $this;
    }
    /**
     * @param $RecipientId
     * @return $this
     */
    public function filterByRecipientId($RecipientId)
    {
        $this->where .= " AND RecipientId $RecipientId";
        $this->placeholders[] = $RecipientId;

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
     * @return MessageCollection
     * @throws \Exception
     */
    public function findAll()
    {
        $db = DatabaseData::getInstance(\RedDevil\Config\DatabaseConfig::DB_INSTANCE);

        $this->query = "SELECT * FROM messages" . $this->where . $this->order;
        $result = $db->prepare($this->query);
        $result->execute([]);

        $collection = [];
        foreach ($result->fetchAll() as $entityInfo) {
            $entity = new Message($entityInfo['SenderId'],
$entityInfo['RecipientId'],
$entityInfo['Content'],
$entityInfo['CreatedOn'],
$entityInfo['id']);

            $collection[] = $entity;
            self::$selectedObjectPool[] = $entity;
        }

        $this->where = substr($this->where, 0, 8);
        return new MessageCollection($collection);
    }

    /**
     * @return Message
     * @throws \Exception
     */
    public function findOne()
    {
        $db = DatabaseData::getInstance(\RedDevil\Config\DatabaseConfig::DB_INSTANCE);

        $this->query = "SELECT * FROM messages" . $this->where . $this->order . " LIMIT 1";
        $result = $db->prepare($this->query);
        $result->execute([]);
        $entityInfo = $result->fetch();
        $entity = new Message($entityInfo['SenderId'],
$entityInfo['RecipientId'],
$entityInfo['Content'],
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

        $this->query = "DELETE FROM messages" . $this->where;
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);

        return $result->rowCount() > 0;
    }

    public static function add(Message $model)
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

    private static function update(Message $model)
    {
        $db = DatabaseData::getInstance(\RedDevil\Config\DatabaseConfig::DB_INSTANCE);

        $query = "UPDATE messages SET SenderId= :SenderId, RecipientId= :RecipientId, Content= :Content, CreatedOn= :CreatedOn WHERE id = :id";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':id' => $model->getId(),
':SenderId' => $model->getSenderId(),
':RecipientId' => $model->getRecipientId(),
':Content' => $model->getContent(),
':CreatedOn' => $model->getCreatedOn()
            ]
        );
    }

    private static function insert(Message $model)
    {
        $db = DatabaseData::getInstance(\RedDevil\Config\DatabaseConfig::DB_INSTANCE);

        $query = "INSERT INTO messages (SenderId,RecipientId,Content,CreatedOn) VALUES (:SenderId, :RecipientId, :Content, :CreatedOn);";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':SenderId' => $model->getSenderId(),
':RecipientId' => $model->getRecipientId(),
':Content' => $model->getContent(),
':CreatedOn' => $model->getCreatedOn()
            ]
        );
        $model->setId($db->lastInsertId());
    }

    private function isColumnAllowed($column)
    {
        $refc = new \ReflectionClass('\RedDevil\Models\Message');
        $consts = $refc->getConstants();

        return in_array($column, $consts);
    }
}