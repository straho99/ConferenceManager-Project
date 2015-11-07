<?php

namespace RedDevil\Core;

use RedDevil\Config\RoutesConfig;

class RouteMapper {

    public static function mapRoute($route)
    {
        foreach (RoutesConfig::$ROUTES as $existingRoute) {
            if (strpos($existingRoute['route'], '{') === false) {
                if ($route == $existingRoute['route']) {
                    return $existingRoute;
                }
            } else {
                $parameterRoute = new \RedDevil\Core\ParameterRoute($existingRoute['route']);
                if ($parameterRoute->isMatching($route)) {
                    $existingRoute['parameters'] = $parameterRoute->parameterValues;
                    return $existingRoute;
                }
            }
        }

        return false;
    }
}