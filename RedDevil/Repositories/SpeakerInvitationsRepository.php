<?php
namespace RedDevil\Repositories;

use RedDevil\Core\DatabaseData;
use RedDevil\Models\SpeakerInvitation;
use RedDevil\Collections\SpeakerInvitationCollection;

class SpeakerInvitationsRepository
{
    private $query;

    private $where = " WHERE 1";

    private $placeholders = [];

    private $order = '';

    private static $selectedObjectPool = [];
    private static $insertObjectPool = [];

    /**
     * @var SpeakerInvitationsRepository
     */
    private static $inst = null;

    private function __construct() { }

    /**
     * @return SpeakerInvitationsRepository
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
     * @param $SpeakerId
     * @return $this
     */
    public function filterBySpeakerId($SpeakerId)
    {
        $this->where .= " AND SpeakerId $SpeakerId";
        $this->placeholders[] = $SpeakerId;

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
     * @return SpeakerInvitationCollection
     * @throws \Exception
     */
    public function findAll()
    {
        $db = DatabaseData::getInstance(\RedDevil\Config\DatabaseConfig::DB_INSTANCE);

        $this->query = "SELECT * FROM speakerInvitations" . $this->where . $this->order;
        $result = $db->prepare($this->query);
        $result->execute([]);

        $collection = [];
        foreach ($result->fetchAll() as $entityInfo) {
            $entity = new SpeakerInvitation($entityInfo['Id'],
$entityInfo['LectureId'],
$entityInfo['SpeakerId'],
$entityInfo['Status']);

            $collection[] = $entity;
            self::$selectedObjectPool[] = $entity;
        }

        $this->where = substr($this->where, 0, 8);
        return new SpeakerInvitationCollection($collection);
    }

    /**
     * @return SpeakerInvitation
     * @throws \Exception
     */
    public function findOne()
    {
        $db = DatabaseData::getInstance(\RedDevil\Config\DatabaseConfig::DB_INSTANCE);

        $this->query = "SELECT * FROM speakerInvitations" . $this->where . $this->order . " LIMIT 1";
        $result = $db->prepare($this->query);
        $result->execute([]);
        $entityInfo = $result->fetch();
        $entity = new SpeakerInvitation($entityInfo['Id'],
$entityInfo['LectureId'],
$entityInfo['SpeakerId'],
$entityInfo['Status']);

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

        $this->query = "DELETE FROM speakerInvitations" . $this->where;
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);

        return $result->rowCount() > 0;
    }

    public static function add(SpeakerInvitation $model)
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

    private static function update(SpeakerInvitation $model)
    {
        $db = DatabaseData::getInstance(\RedDevil\Config\DatabaseConfig::DB_INSTANCE);

        $query = "UPDATE speakerInvitations SET Id= :Id, LectureId= :LectureId, SpeakerId= :SpeakerId, Status= :Status WHERE id = :id";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':Id' => $model->getId(),
':LectureId' => $model->getLectureId(),
':SpeakerId' => $model->getSpeakerId(),
':Status' => $model->getStatus()
            ]
        );
    }

    private static function insert(SpeakerInvitation $model)
    {
        $db = DatabaseData::getInstance(\RedDevil\Config\DatabaseConfig::DB_INSTANCE);

        $query = "INSERT INTO users (Id,LectureId,SpeakerId,Status) VALUES (:Id, :LectureId, :SpeakerId, :Status);";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':Id' => $model->getId(),
':LectureId' => $model->getLectureId(),
':SpeakerId' => $model->getSpeakerId(),
':Status' => $model->getStatus()
            ]
        );
        $model->setId($db->lastInsertId());
    }

    private function isColumnAllowed($column)
    {
        $refc = new \ReflectionClass('\RedDevil\Models\SpeakerInvitation');
        $consts = $refc->getConstants();

        return in_array($column, $consts);
    }
}