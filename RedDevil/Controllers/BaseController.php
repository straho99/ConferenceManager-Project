<?php

namespace RedDevil\Controllers;

use RedDevil\EntityManager\DatabaseContext;
use RedDevil\Services\ServiceResponse;

abstract class BaseController {
    protected $isPost = false;
    protected $dbContext;

    public $ViewBag = [];

    public function __construct(DatabaseContext $dbContext)
    {
        $this->dbContext = $dbContext;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->isPost = true;
        }
        $this->onInit();
    }

    public function onInit() {
        // Implement initializing logic in the subclasses
    }

    public function index() {
        // Implement the default action in the subclasses
    }

    public function isLogged()
    {
        return isset($_SESSION['userId']);
    }

    public function redirectToUrl($url) {
//        $baseRoute = $this->baseUrl();
//        $fullUrl = $baseRoute . '/'. $url;
        header("Location: " . $url);
        exit;
    }

    public function redirect($controllerName, $actionName = null, $params = null) {
        $url = '/' . urlencode($controllerName);
        if ($actionName != null) {
            $url .= '/' . urlencode($actionName);
        }
        if ($params != null) {
            $encodedParams = array_map($params, 'urlencode');
            $url .= implode('/', $encodedParams);
        }
        $this->redirectToUrl($url);
    }

    public function addMessage(string $msg, string $type) {
        if (!isset($_SESSION['messages'])) {
            $_SESSION['messages'] = array();
        };
        array_push($_SESSION['messages'],
            array('text' => $msg, 'type' => $type));
    }

    public function addInfoMessage(string $msg) {
        $this->addMessage($msg, 'info');
    }

    public function addErrorMessage(string $msg) {
        $this->addMessage($msg, 'error');
    }

    /**
     * @param ServiceResponse $response
     * @throws \Exception
     */
    public function processResponse(ServiceResponse $response)
    {
        if ($response->hasError()) {
            if ($response->getErrorCode() > 1) {
                throw new \Exception($response->getMessage(), $response->getErrorCode());
            } else {
                $this->addErrorMessage($response->getMessage());
            }
        } else {
            $this->addInfoMessage($response->getMessage());
        }
    }

    protected function baseUrl() : string
    {
        $requestParts = explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        $indexBaseProjectFolder = array_search(\RedDevil\Config\AppConfig::BASE_PROJECT_FOLDER, $requestParts);

        $requestParts = array_slice($requestParts, $indexBaseProjectFolder + 1);
        $route = implode('/', $requestParts);

        if (strlen($route) > 1 &&   $route[0] == '/') {
            $route = substr($route, 1, strlen($route));
        }

        return $route;
    }
}