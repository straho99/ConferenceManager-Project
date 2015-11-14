<?php

namespace RedDevil\Core\Identity\Statements;

use RedDevil\Config\DatabaseConfig;
use RedDevil\Core\DatabaseData;

class TableCrudOps {

    public function createTable($name) {
        $db = DatabaseData::getInstance(DatabaseConfig::DB_INSTANCE);
        $query = str_replace('{{name}}', $name, self::CREATE_TABLE);

        try {
            $statement = $db->query($query);
            $statement->execute([]);
            return true;
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function dropTable($name) {
        $db = DatabaseData::getInstance(DatabaseConfig::DB_INSTANCE);
        $query = str_replace('{{name}}', $name, self::DROP_TABLE);

        try {
            $statement = $db->query($query);
            $statement->execute([]);
            return true;
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function addColumn($table, $column, $type) {
        $db = DatabaseData::getInstance(DatabaseConfig::DB_INSTANCE);
        $query = str_replace('{{table}}',$table, self::UPDATE_TABLE_ADD_COL);
        $query = str_replace('{{column}}', $column, $query);
        $query = str_replace('{{type}}', $type, $query);

        try {
            $statement = $db->query($query);
            $statement->execute([]);
            return true;
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function dropColumn($table, $column) {
        $db = DatabaseData::getInstance(DatabaseConfig::DB_INSTANCE);
        $query = str_replace('{{table}}', $table, self::UPDATE_TABLE_DELETE_COL);
        $query = str_replace('{{column}}', $column, $query);

        try {
            $statement = $db->query($query);
            $statement->execute([]);
            return true;
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function modifyColumn($table, $column, $type) {
        $db = DatabaseData::getInstance(DatabaseConfig::DB_INSTANCE);
        $query = str_replace('{{table}}',$table, self::UPDATE_TABLE_MODIFY_COL);
        $query = str_replace('{{column}}', $column, $query);
        $query = str_replace('{{type}}', $type, $query);

        try {
            $statement = $db->query($query);
            $statement->execute([]);
            return true;
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function tableExists($table) {
        $db = DatabaseData::getInstance(DatabaseConfig::DB_INSTANCE);
        $query = str_replace('{{table}}',$table, self::TABLE_EXISTS);

        try {
            $statement = $db->query($query);
            $statement->execute([]);
            return $statement->rowCount() > 0;
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function insertRole($role) {
        $db = DatabaseData::getInstance(DatabaseConfig::DB_INSTANCE);
        $statement = $db->prepare(self::INSERT_ROLE);

        try {
            $statement->execute([$role]);
            return $statement->rowCount() > 0;
        } catch (\Exception $ex) {
            return false;
        }
    }

    const CREATE_TABLE = <<<TAG
CREATE TABLE {{name}} (id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY)
TAG;

    const DROP_TABLE = <<<TAG
DROP TABLE IF EXISTS {{name}}
TAG;


    const UPDATE_TABLE_ADD_COL = <<<TAG
ALTER TABLE {{table}}
ADD COLUMN {{column}} {{type}}
TAG;


    const UPDATE_TABLE_DELETE_COL = <<<TAG
ALTER TABLE {{table}}
DROP COLUMN {{column}}
TAG;

    const UPDATE_TABLE_MODIFY_COL = <<<TAG
ALTER TABLE {{table}} MODIFY {{column}} {{type}}
TAG;

    const TABLE_EXISTS = <<<TAG
SHOW TABLES LIKE '{{table}}'
TAG;

    const INSERT_ROLE = <<<TAG
INSERT INTO roles (id, title) values (null, ?)
TAG;
}