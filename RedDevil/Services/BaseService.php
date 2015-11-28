<?php

namespace RedDevil\Services;

use DateTime;
use DateTimeZone;
use RedDevil\EntityManager\DatabaseContext;

class BaseService {
    protected $dbContext;

    function __construct(DatabaseContext $dbContext)
    {
        $this->dbContext = $dbContext;
    }

    public function compareTo(IDateTimeInterval $first, IDateTimeInterval $second)
    {
        $test = $first->getStartDate();
        $firstStartDate = (new DateTime($first->getStartDate()))->getTimestamp();
        $firstEndDate = (new DateTime($first->getEndDate()))->getTimestamp();

        $secondStartDate = (new DateTime($second->getStartDate()))->getTimestamp();
        $secondEndDate = (new DateTime($second->getEndDate()))->getTimestamp();

        if ($firstEndDate < $secondStartDate) {
            return -1;
        } else if($firstStartDate > $secondEndDate) {
            return 1;
        } else {
            return 0;
        }
    }

    public function contains(IDateTimeInterval $first, IDateTimeInterval $second)
    {
        $firstStartDate = strtotime($first->getStartDate());
        $firstEndDate = strtotime($first->getEndDate());

        $secondStartDate = strtotime($second->getStartDate());
        $secondEndDate = strtotime($second->getEndDate());

        if ($secondStartDate >= $firstStartDate &&
            $secondStartDate <= $firstEndDate &&
            $secondEndDate >= $firstStartDate &&
            $secondEndDate<= $firstEndDate
        ) {
            return true;
        } else {
            return false;
        }
    }
}