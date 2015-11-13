<?php

namespace RedDevil;

use RedDevil\Config\AppConfig;
use RedDevil\Core\HttpContext;
use RedDevil\Core\RouteConfigurator;
use RedDevil\Core\Annotations;
use RedDevil\EntityManager\DatabaseContext;
use RedDevil\ORM\OrmManager;

class Application {
    private $route;
    private $controller;
    /**
     * @var \RedDevil\Core\Annotations\Annotation[]
     */
    private $annotationFilters = [];

    const CONTROLLERS_NAMESPACE = "RedDevil\\Controllers\\";

    public function __construct($route)
    {
        set_exception_handler(array($this, '_exceptionHandler'));

        RouteConfigurator::configRoutes();
        $this->route = \RedDevil\Core\RouteMapper::mapRoute($route);

        // If no area-route or standard route has been found - assign default route and action
        if (!$this->route) {
            $this->route['controller'] = AppConfig::DEFAULT_CONTROLLER;
            $this->route['action'] = AppConfig::$DEFAULT_ACTIONS[$this->route['controller']];
            $this->route['annotations'] = [];
        }

        $this->createAnnotationFilters($this->route);
    }

    public function start()
    {
        $context = HttpContext::getInstance();
        $context->setGet($_GET);
        $context->setPost($_POST);
        $context->setCookies($_COOKIE);
        $context->setSession($_SESSION);
        $context->setMethod(strtolower($_SERVER['REQUEST_METHOD']));

        OrmManager::update();

        $this->initController();

        $bindingModels = \RedDevil\Core\BindingModelMapper::mapBindingModels($this->controller, $this->route['action']);
        if (!array_key_exists('parameters', $this->route)) {
            $this->route['parameters'] = [];
            $this->route['parameters'] = $bindingModels;
        } else {
            $this->route['parameters'] = array_merge($bindingModels, $this->route['parameters']);
        }

        foreach ($this->annotationFilters as $filter) {
            $filter->onBeforeExecute();
        }

        call_user_func_array(
            [
                $this->controller,
                $this->route['action']
            ],
            $this->route['parameters']
        );

        foreach ($this->annotationFilters as $filter) {
            $filter->onAfterExecute();
        }
    }

    private function initController()
    {
        $controllerClassName = $this->route['controller'];
        $this->controller = new $controllerClassName(new DatabaseContext(
            \RedDevil\Repositories\RolesRepository::create(),
            \RedDevil\Repositories\TodosRepository::create(),
            \RedDevil\Repositories\UsersRepository::create()
        ));
    }

    public function _exceptionHandler(\Exception $ex) {
        if (AppConfig::DISPLAY_ERRORS == true) {
            echo '<pre>' . print_r($ex, true) . '</pre>';
        } else {
            $this->displayError($ex);
        }
    }

    public function displayError($ex) {
        try {
            $errorModel = [
                'code' => $ex->getCode(),
                'message' => $ex->getMessage()
            ];
            return new View('Errors', 'Error', $errorModel);
        } catch (\Exception $exc) {
            \RedDevil\Core\Common::headerStatus($ex->getCode());
            echo '<h1>' . $ex . '</h1>';
            exit;
        }
    }

    private function createAnnotationFilters($route)
    {
        $availableAnnotations = [];

        $dirHandle = opendir('Core' . DIRECTORY_SEPARATOR . 'Annotations');
        $file = readdir($dirHandle);
        while ($file) {
            if ($file[0] == '.') {
                $file = readdir($dirHandle);
                continue;
            }

            if ($file == 'Annotation.php') {
                $file = readdir($dirHandle);
                continue;
            }

            $annotationClassName = explode('.', $file)[0];
            $availableAnnotations[] = $annotationClassName;
            $file = readdir($dirHandle);
        }

        foreach ($route['annotations'] as $key => $value) {
            $annotationName = ucfirst($key) . 'Annotation';
            if (!in_array($annotationName, $availableAnnotations)) {
                throw new \Exception("Unrecognized annotation class.", 501);
            }

            $annotationName = '\\RedDevil\\Core\\Annotations\\' . $annotationName;
            $this->annotationFilters[] = new $annotationName($value);
        }
    }
}