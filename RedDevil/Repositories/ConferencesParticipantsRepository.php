<?php
namespace RedDevil\Repositories;

use RedDevil\Core\DatabaseData;
use RedDevil\Models\ConferencesParticipant;
use RedDevil\Collections\ConferencesParticipantCollection;

class ConferencesParticipantsRepository
{
    private $query;

    private $where = " WHERE 1";

    private $placeholders = [];

    private $order = '';

    private static $selectedObjectPool = [];
    private static $insertObjectPool = [];

    /**
     * @var ConferencesParticipantsRepository
     */
    private static $inst = null;

    private function __construct() { }

    /**
     * @return ConferencesParticipantsRepository
     */
    public static function create()
    {
        if (self::$inst == null) {
            self::$inst = new self();
        }

        return self::$inst;
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
     * @param $ParticipantId
     * @return $this
     */
    public function filterByParticipantId($ParticipantId)
    {
        $this->where .= " AND ParticipantId $ParticipantId";
        $this->placeholders[] = $ParticipantId;

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
     * @return ConferencesParticipantCollection
     * @throws \Exception
     */
    public function findAll()
    {
        $db = DatabaseData::getInstance(\RedDevil\Config\DatabaseConfig::DB_INSTANCE);

        $this->query = "SELECT * FROM conferencesParticipants" . $this->where . $this->order;
        $result = $db->prepare($this->query);
        $result->execute([]);

        $collection = [];
        foreach ($result->fetchAll() as $entityInfo) {
            $entity = new ConferencesParticipant($entityInfo['ConferenceId'],
$entityInfo['ParticipantId'],
$entityInfo['id']);

            $collection[] = $entity;
            self::$selectedObjectPool[] = $entity;
        }

        $this->where = substr($this->where, 0, 8);
        return new ConferencesParticipantCollection($collection);
    }

    /**
     * @return ConferencesParticipant
     * @throws \Exception
     */
    public function findOne()
    {
        $db = DatabaseData::getInstance(\RedDevil\Config\DatabaseConfig::DB_INSTANCE);

        $this->query = "SELECT * FROM conferencesParticipants" . $this->where . $this->order . " LIMIT 1";
        $result = $db->prepare($this->query);
        $result->execute([]);
        $entityInfo = $result->fetch();
        $entity = new ConferencesParticipant($entityInfo['ConferenceId'],
$entityInfo['ParticipantId'],
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

        $this->query = "DELETE FROM conferencesParticipants" . $this->where;
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);

        return $result->rowCount() > 0;
    }

    public static function add(ConferencesParticipant $model)
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

    private static function update(ConferencesParticipant $model)
    {
        $db = DatabaseData::getInstance(\RedDevil\Config\DatabaseConfig::DB_INSTANCE);

        $query = "UPDATE conferencesParticipants SET ConferenceId= :ConferenceId, ParticipantId= :ParticipantId WHERE id = :id";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':ConferenceId' => $model->getConferenceId(),
':ParticipantId' => $model->getParticipantId()
            ]
        );
    }

    private static function insert(ConferencesParticipant $model)
    {
        $db = DatabaseData::getInstance(\RedDevil\Config\DatabaseConfig::DB_INSTANCE);

        $query = "INSERT INTO conferencesParticipants (ConferenceId,ParticipantId) VALUES (:ConferenceId, :ParticipantId);";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':ConferenceId' => $model->getConferenceId(),
':ParticipantId' => $model->getParticipantId()
            ]
        );
        $model->setId($db->lastInsertId());
    }

    private function isColumnAllowed($column)
    {
        $refc = new \ReflectionClass('\RedDevil\Models\ConferencesParticipant');
        $consts = $refc->getConstants();

        return in_array($column, $consts);
    }
}