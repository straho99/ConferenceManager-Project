<?php

namespace RedDevil\InputModels\Search;

use RedDevil\InputModels\BaseInputModel;

class SearchInputModel extends BaseInputModel {
    private $keyword;

    function __construct()
    {
        parent::__construct();
    }

    /**
     * @return $keyword
     */
    public function getKeyword()
    {
        return $this->lectureId;
    }

    /**
     * @param mixed $keyword
     */
    public function setKeyword($keyword)
    {
        $this->keyword = $keyword;
    }

    public function validate()
    {
        $this->validator->setRule('required', $this->keyword, null,
            'keyword | Keyword is required.');

        parent::validate();
    }
}
