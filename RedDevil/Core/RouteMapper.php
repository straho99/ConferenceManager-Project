<?php

namespace RedDevil\Core;

use RedDevil\Config\RoutesConfig;
use RedDevil\Core\ParameterRoute;

class RouteMapper {

    public static function mapRoute($route)
    {
        foreach (RoutesConfig::$ROUTES as $existingRoute) {
            if (strpos($existingRoute['route'], '{') === false) {
                if ($route == $existingRoute['route']) {
                    return $existingRoute;
                }
            } else {
                $parameterRoute = new ParameterRoute($existingRoute['route']);
                if ($parameterRoute->isMatching($route)) {
                    $existingRoute['parameters'] = $parameterRoute->parameterValues;
                    return $existingRoute;
                }
            }
        }

        return false;
    }
}