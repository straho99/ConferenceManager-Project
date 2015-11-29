<?php

namespace RedDevil\InputModels\Conference;

use RedDevil\InputModels\BaseInputModel;

class BatchBookLectures extends BaseInputModel {
    private $lectureIds;

    function __construct()
    {
        parent::__construct();
    }


    /**
     * @return mixed
     */
    public function getLectureIds()
    {
        return $this->lectureIds;
    }

    /**
     * @param mixed $lectureIds
     */
    public function setLectureIds($lectureIds)
    {
        $this->lectureIds = $lectureIds;
    }
}