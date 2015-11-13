<?php

namespace RedDevil\Config;

class AppConfig {
    const BASE_PROJECT_FOLDER = "RedDevil";

    const OPERATION_MODE = 'development';

    const DEFAULT_CONTROLLER = 'RedDevil\\Controllers\\ExperimentController';

    const DISPLAY_ERRORS = true;

    public static $DEFAULT_ACTIONS = array(
        'RedDevil\\Controllers\\UserController' => 'register',
        'RedDevil\\Controllers\\ExperimentController' => 'index'
    );

    public static $DEFAULT_CONTROLLERS_FOR_AREAS = array(
        'Area1' => 'AreaController',
        'Area2' => 'AnotherController'
    );

    public static $DEFAULT_ACTIONS_FOR_AREA_CONTROLLERS = array(
        'AreaController' => 'doSomething',
        'AnotherController' => 'doSomethingElse'
    );

    const VIEW_FOLDER = 'Views';
    const VIEW_EXTENSION = '.php';

    const DEFAULT_LAYOUT = 'Default';

    const ROUTES_CONFIG = 'Config/RoutesConfig.php';
}