<?php

namespace RedDevil\ORM;

/**
 * @Credits: the basics of this class are developed by Ivan Yonkov - a.k.a. 'RoYal'.
 */
class Collections {
    
    public static function create($model)
    {
        $modelCollection = $model . 'Collection';
        $modelName = $model . 's';
        $modelArray = $model . '[]';
        return <<<KUF
<?php

namespace RedDevil\Collections;

use RedDevil\Models\\$model;

class $modelCollection
{
    /**
     * @var $modelArray;
     */
    private \$collection = [];

    public function __construct(\$models = [])
    {
        \$this->collection = \$models;
    }

    /**
     * @return $modelArray
     */
    public function get$modelName()
    {
        return \$this->collection;
    }

    /**
     * @param callable \$callback
     */
    public function each(Callable \$callback)
    {
        foreach (\$this->collection as \$model) {
            \$callback(\$model);
        }
    }
}
KUF;
    }
}