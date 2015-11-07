<?php
namespace RedDevil\Models;
use RedDevil\Core\DatabaseData;

abstract class BaseModel {
    protected $db;

    public function __construct()
    {
        $this->db = DatabaseData::getInstance('todos');
    }
}