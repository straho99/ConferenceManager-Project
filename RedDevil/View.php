<?php

namespace RedDevil;

class View {
    private $layout;

    private $areaName;
    private $controllerName;
    private $actionName;
    private $model;
    private $toEscape;

    public static $viewBag = [];

    const PARAMS_COUNT_MODEL_AND_VIEW = 2;
    const PARAMS_COUNT_MODEL_ONLY = 1;

    public function __construct(
        $controllerName = null,
        $actionName = null,
        $model = null,
        $layout = 'Default',
        $areaName = null,
        $toEscape = true)
    {
        $this->model = $model;
        $this->layout = $layout;
        $this->areaName = $areaName;
        $this->toEscape = $toEscape;

        if ($areaName == null) {
            $this->controllerName = $controllerName == null ?
                \RedDevil\Config\AppConfig::DEFAULT_CONTROLLER : $controllerName;

            $this->actionName = $actionName != null ?
                $actionName : \RedDevil\Config\AppConfig::$DEFAULT_ACTIONS[$this->controllerName];
        } else {
            $this->controllerName = $controllerName == null ?
                \RedDevil\Config\AppConfig::$DEFAULT_CONTROLLERS_FOR_AREAS[$areaName] :
                    $controllerName;

            $this->actionName = $actionName == null ?
                \RedDevil\Config\AppConfig::$DEFAULT_ACTIONS_FOR_AREA_CONTROLLERS[$this->controllerName] :
                $actionName;
        }

        $this->loadView($this->model);
    }

    /**
     * @return bool
     */
    private function includeLayout()
    {
        return isset($this->layout);
    }

    private function includeLayoutHeader()
    {
        if ($this->includeLayout()) {
            $path = \RedDevil\Config\AppConfig::VIEW_FOLDER
                . DIRECTORY_SEPARATOR
                . 'Layouts'
                . DIRECTORY_SEPARATOR
                . $this->layout
                . DIRECTORY_SEPARATOR
                . 'header.php';

            require $path;
        }
    }

    private function includeLayoutFooter()
    {
        if ($this->includeLayout()) {
            $path = \RedDevil\Config\AppConfig::VIEW_FOLDER
                . DIRECTORY_SEPARATOR
                . 'Layouts'
                . DIRECTORY_SEPARATOR
                . $this->layout
                . DIRECTORY_SEPARATOR
                . 'footer.php';

            require $path;
        }
    }

    private function loadView($model)
    {
        if(!$this->checkViewModel($model)) {
            throw new \Exception('Invalid ViewModel passed to view.');
        }

        if ($this->toEscape) {
            $this->escapeModel($model);
        }

        $this->includeLayoutHeader();
        require $this->getViewFullPathAndName();

        $this->includeLayoutFooter();
    }
    
    private function escapeModel(&$model)
    {
        if (is_array($model)) {
            foreach ($model as $key => &$value) {
                if (is_object($value)) {
                    $reflection = new \ReflectionClass($value);
                    $properties = $reflection->getProperties();

                    foreach ($properties as &$property) {
                        $property->setAccessible(true);
                        $property->setValue($value, $this->escapeModel($property->getValue($value)));
                    }
                } else if(is_array($value)) {
                    $this->escapeModel($value);
                } else {
                    $value = htmlspecialchars($value);
                }
            }
        } else if(is_object($model)) {
            $reflection = new \ReflectionClass($model);
            $properties = $reflection->getProperties();

            foreach ($properties as &$property) {
                $property->setAccessible(true);
                $theValue = $property->getValue($model);
                $property->setValue($model, $this->escapeModel($theValue));
            }
        } else {
            $model = htmlspecialchars($model);
        }
        return $model;
    }

    private function checkViewModel($model)
    {
        $fileName = $this->getViewFullPathAndName();
        $contents = file_get_contents($fileName);
        $rows = explode(PHP_EOL, $contents);
        $modelTypeAnnotation = $rows[0];
        preg_match_all("/@var\s+([a-zA-Z]+)/", $modelTypeAnnotation, $matches);

        if (count($matches[0]) == 0) {
            return true;
        }
        $type = trim($matches[1][0]);

        if (!$type) {
            return true;
        }

        if (!is_object($model)) {
            return false;
        }

        $modelClass = get_class($model);
        $modelClass = explode('\\', $modelClass);
        $modelClassName = end($modelClass);

        if ($modelClassName != $type) {
            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    private function getViewFullPathAndName()
    {
        if ($this->areaName == null) {
            $fileName = \RedDevil\Config\AppConfig::VIEW_FOLDER
                . DIRECTORY_SEPARATOR
                . $this->controllerName
                . DIRECTORY_SEPARATOR
                . $this->actionName
                . \RedDevil\Config\AppConfig::VIEW_EXTENSION;
            return $fileName;
        } else {

            $fileName = "Areas"
                . DIRECTORY_SEPARATOR
                . $this->areaName
                . DIRECTORY_SEPARATOR
                . "Views"
                . DIRECTORY_SEPARATOR
                . $this->controllerName
                . DIRECTORY_SEPARATOR
                . $this->actionName
                . \RedDevil\Config\AppConfig::VIEW_EXTENSION;
            return $fileName;
        }
    }
}