<?php

namespace RedDevil\Core\Identity;

class IdentityUserTable {
    private $columns = [];

    public function hasColumn($columnName)
    {
        return array_key_exists($columnName, $this->columns);
    }

    public function getColumnType($columnName)
    {
        if (array_key_exists($columnName, $this->columns)) {
            return $this->columns[$columnName];
        } else {
            return null;
        }
    }

    public function setColumn($columnName, $columnValue)
    {
        $this->columns[$columnName] = $columnValue;
    }

    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * @param \RedDevil\Core\Identity\IdentityUserTable $anotherUserTable
     * @return bool
     */
    public function equals($anotherUserTable)
    {
        foreach ($this->columns as $key => $value) {
            if (!$anotherUserTable->hasColumn($key)) {
                return false;
            } else {
                if ($value !== $anotherUserTable->getColumnType($key)) {
                    return false;
                }
            }
        }

        return true;
    }
}