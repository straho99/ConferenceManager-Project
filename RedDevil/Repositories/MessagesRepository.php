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
            $entity = new Message($entityInfo['Id'],
$entityInfo['SenderId'],
$entityInfo['RecipientId'],
$entityInfo['Content']);

            $collection[] = $entity;
            self::$selectedObjectPool[] = $entity;
        }

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
        $entity = new Message($entityInfo['Id'],
$entityInfo['SenderId'],
$entityInfo['RecipientId'],
$entityInfo['Content']);

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

        $query = "UPDATE messages SET Id= :Id, SenderId= :SenderId, RecipientId= :RecipientId, Content= :Content WHERE id = :id";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':Id' => $model->getId(),
':SenderId' => $model->getSenderId(),
':RecipientId' => $model->getRecipientId(),
':Content' => $model->getContent()
            ]
        );
    }

    private static function insert(Message $model)
    {
        $db = DatabaseData::getInstance(\RedDevil\Config\DatabaseConfig::DB_INSTANCE);

        $query = "INSERT INTO users (Id,SenderId,RecipientId,Content) VALUES (:Id, :SenderId, :RecipientId, :Content);";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':Id' => $model->getId(),
':SenderId' => $model->getSenderId(),
':RecipientId' => $model->getRecipientId(),
':Content' => $model->getContent()
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