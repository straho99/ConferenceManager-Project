<?php

ini_set('display_errors', 1);

ob_start();
session_start();
require_once "Autoloader.php";
\RedDevil\Autoloader::init();

$requestParts = explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$indexBaseProjectFolder = array_search(\RedDevil\Config\AppConfig::BASE_PROJECT_FOLDER, $requestParts);

$requestParts = array_slice($requestParts, $indexBaseProjectFolder + 1);
$route = implode('/', $requestParts);

if (strlen($route) > 1 &&   $route[0] == '/') {
    $route = substr($route, 1, strlen($route));
}

\RedDevil\Core\DatabaseData::setInstance(
    RedDevil\Config\DatabaseConfig::DB_INSTANCE,
    RedDevil\Config\DatabaseConfig::DB_DRIVER,
    RedDevil\Config\DatabaseConfig::DB_USER,
    RedDevil\Config\DatabaseConfig::DB_PASS,
    RedDevil\Config\DatabaseConfig::DB_NAME,
    RedDevil\Config\DatabaseConfig::DB_HOST
);

$app = new \RedDevil\Application($route);
$app->start();
?>