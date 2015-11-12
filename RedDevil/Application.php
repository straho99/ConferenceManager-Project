<?php

namespace RedDevil;

use RedDevil\Config\AppConfig;
use RedDevil\Core\HttpContext;
use RedDevil\Core\RouteConfigurator;
use RedDevil\Models\UserModel;

class Application {
    private $route;
    private $controller;

    const CONTROLLERS_NAMESPACE = "RedDevil\\Controllers\\";

    public function __construct($route)
    {
        RouteConfigurator::configRoutes();
        $this->route = \RedDevil\Core\RouteMapper::mapRoute($route);

        // If no area-route or standard route has been found - assign default route and action
        if (!$this->route) {
            $this->route['controller'] = AppConfig::DEFAULT_CONTROLLER;
            $this->route['action'] = AppConfig::$DEFAULT_ACTIONS[$this->route['controller']];
            $this->route['annotations'] = [];
        }
    }

    public function start()
    {
        $context = HttpContext::getInstance();
        $context->setGet($_GET);
        $context->setPost($_POST);
        $context->setCookies($_COOKIE);
        $context->setSession($_SESSION);
        $context->setMethod(strtolower($_SERVER['REQUEST_METHOD']));

        $this->initController();

        $bindingModels = \RedDevil\Core\BindingModelMapper::mapBindingModels($this->controller, $this->route['action']);
        if (!array_key_exists('parameters', $this->route)) {
            $this->route['parameters'] = [];
            $this->route['parameters'] = $bindingModels;
        } else {
            $this->route['parameters'] = array_merge($bindingModels, $this->route['parameters']);
        }

        // First, check if the route needs user authorization (logged-in user)
        if (array_key_exists('authorize', $this->route['annotations'])) {
            if (!isset($_SESSION['userId'])) {
                header('HTTP/1.1 401 Unauthorized', true, 401);
                die ('Unauthorized.');
            }
        }

        // Second, check if the route needs to be called on specific request method
        if (array_key_exists('method', $this->route['annotations'])) {
            $requiredMethod = $this->route['annotations']['method'];

            if ($requiredMethod != strtolower($_SERVER['REQUEST_METHOD'])) {
                header('HTTP/1.1 404 Not Found', true, 404);
                die ('Not Found.');
            }
        }

        // Third, check if the route needs the user to be have a certain (minimum) role
        if (array_key_exists('role', $this->route['annotations'])) {
            if (!isset($_SESSION['userId'])) {
                header('HTTP/1.1 401 Unauthorized', true, 401);
                die ('Unauthorized.');
            }

            $user =new \RedDevil\Models\UserModel();
            $userRoleId = $user->getRoleIdForUser($_SESSION['userId']);
            $requiredRoleId = $user->getRoleIdForTitle($this->route['annotations']['role']);

            if ($userRoleId < $requiredRoleId) {
                header('HTTP/1.1 401 Unauthorized', true, 401);
                die ('Unauthorized.');
            }
        }

        $this->initController();

        call_user_func_array(
            [
                $this->controller,
                $this->route['action']
            ],
            $this->route['parameters']
        );
    }

    private function initController()
    {
        $controllerClassName = $this->route['controller'];
        $this->controller = new $controllerClassName();
    }
}