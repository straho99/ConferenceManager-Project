<?php

namespace RedDevil\Services;

use RedDevil\EntityManager\DatabaseContext;

class BaseService {
    protected $dbContext;

    function __construct(DatabaseContext $dbContext)
    {
        $this->dbContext = $dbContext;
    }


}