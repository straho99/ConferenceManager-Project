<?php

namespace RedDevil\Core;
use RedDevil\Config\AppConfig;
use ReflectionClass as ReflectionClass;
use ReflectionMethod as ReflectionMethod;

class RouteConfigurator {

    const CONTROLLERS_NAMESPACE = "RedDevil\\Controllers\\";

    public static function configRoutes()
    {
        if (AppConfig::OPERATION_MODE == 'production') {
            if (!self::isItTime()) {
                return;
            }
        }

        $allRoutes = [];
        $areaRoutes = self::findRoutesAreas();
        if ($areaRoutes != null) {
            $allRoutes = $areaRoutes['annotationRoutes'];
        }

        $frameworkRoutes = self::findRoutesFramework();
        if ($frameworkRoutes !== null) {
            $allRoutes = array_merge($allRoutes, $frameworkRoutes['annotationRoutes']);
        }

        $allRoutes = array_merge($allRoutes, $areaRoutes['routes']);
        $allRoutes = array_merge($allRoutes, $frameworkRoutes['routes']);

        self::createRoutesConfig($allRoutes);
    }

    /**
     * @return bool
     */
    private static function isItTime()
    {
        $dateLastConfiguration = new \DateTime(\RedDevil\Config\RoutesConfig::$dateOfLastCheck);
        $now = new \DateTime();
        $hoursPassed = $now->diff($dateLastConfiguration)->days * 24 +
            $now->diff($dateLastConfiguration)->h;

        if ($hoursPassed > 1) {
            return true;
        }

        return false;
    }

    private static function findRoutesFramework()
    {
        $controllerNames = [];
        $routes = [];
        $annotationRoutes = [];

        if (!file_exists('Controllers')) {
            return null;
        }

        $dirHandle = opendir('Controllers');

        $file = readdir($dirHandle);
        while ($file) {
            if ($file[0] == '.') {
                $file = readdir($dirHandle);
                continue;
            }

            $index = strpos($file, 'Base') === false ? false : true;
            if ($index) {
                $file = readdir($dirHandle);
                continue;
            }

            $controllerNames[] = substr($file, 0, strlen($file) - 4);
            $file = readdir($dirHandle);
        }

        foreach ($controllerNames as $controllerName) {
            $fullControllerName =
                self::CONTROLLERS_NAMESPACE
                . $controllerName;

            $class = new ReflectionClass($fullControllerName);
            $methods = $class->getMethods(ReflectionMethod::IS_PUBLIC);

            foreach ($methods as $method) {
                if(strpos($method->class, 'BaseController') === false &&
                    $method->name !== '__construct') {

                    $annotations = self::getAnnotationsForMethod($method);

                    $routes[] = [
                        'controller' => $fullControllerName,
                        'action' => $method->name,
                        'route' => strtolower(str_replace('Controller', '', $controllerName)) . '/' . $method->name,
                        'annotations' => $annotations == null? [] : $annotations
                    ];

                    $annotationRoute = self::getRouteForMethod($method);
                    if ($annotationRoute !== null) {
                        $annotationRoutes[] = [
                            'controller' => $fullControllerName,
                            'action' => $method->name,
                            'route' => $annotationRoute,
                            'annotations' => $annotations == null? [] : $annotations
                        ];
                    }
                }
            }
        }

        closedir($dirHandle);

        return [
            'routes' => $routes,
            'annotationRoutes' => $annotationRoutes
        ];
    }

    private static function findRoutesAreas()
    {
        $routes = [];
        $annotationRoutes = [];

        if (!file_exists('Areas')) {
            return null;
        }

        $areasDirHandle = opendir('Areas');
        $areaName = readdir($areasDirHandle);
        while ($areaName) {
            if ($areaName[0] == '.') {
                $areaName = readdir($areasDirHandle);
                continue;
            }

            $controllersDirHandle = opendir('Areas' . '/' . $areaName . '/' . 'Controllers');
            if ($controllersDirHandle === null) {
                continue;
            }

            $file = readdir($controllersDirHandle);
            while ($file) {
                if ($file[0] == '.') {
                    $file = readdir($controllersDirHandle);
                    continue;
                }

                $className = substr($file, 0, strlen($file) - 4);
                $fullControllerName = 'RedDevil\\Areas\\'
                    . $areaName . '\\Controllers\\' . $className;

                $route = strtolower($areaName) . '/' . strtolower(str_replace('Controller', '', $className));

                $class = new ReflectionClass($fullControllerName);
                $methods = $class->getMethods(ReflectionMethod::IS_PUBLIC);

                foreach ($methods as $method) {
                    if(strpos($method->class, 'BaseController') === false &&
                        $method->name !== '__construct') {

                        $annotations = self::getAnnotationsForMethod($method);

                        $routes[] = [
                            'controller' => $fullControllerName,
                            'action' => $method->name,
                            'route' => $route . '/' . $method->name,
                            'annotations' => $annotations == null? [] : $annotations
                        ];

                        $annotationRoute = self::getRouteForMethod($method);
                        if ($annotationRoute !== null) {
                            $annotationRoutes[] = [
                                'controller' => $fullControllerName,
                                'action' => $method->name,
                                'route' => $annotationRoute,
                                'annotations' => $annotations == null? [] : $annotations
                            ];
                        }
                    }
                }

                $file = readdir($controllersDirHandle);
            }

            closedir($controllersDirHandle);
            $areaName = readdir($areasDirHandle);
        }
        closedir($areasDirHandle);

        return [
            'routes' => $routes,
            'annotationRoutes' => $annotationRoutes
        ];
    }

    private static function createRoutesConfig($routes)
    {
        $routeConfigFile = fopen(\RedDevil\Config\AppConfig::ROUTES_CONFIG, "w") or die("Unable to open RouteConfig.php!");

        fwrite($routeConfigFile, "<?php \n");
        fwrite($routeConfigFile, "namespace RedDevil\\Config; \n");
        fwrite($routeConfigFile, "class RoutesConfig { \n");

        $currentDate = new \DateTime();
        $txt = "\t public static \$dateOfLastCheck = '" . $currentDate->format('Y-m-d H:i:s') . "';\n\n";
        fwrite($routeConfigFile, $txt);

        fwrite($routeConfigFile, "\t public static \$ROUTES = [ \n");
        foreach ($routes as $route) {

            $routeText = $route['route'];
            $controllerText = $route['controller'];
            $actionText = $route['action'];

            $annotationText = "\t\t\t 'annotations' => [\n";
            foreach ($route['annotations'] as $key => $value) {
                $valuesArray = explode(", ", $value);
                if (count($valuesArray) > 1) {
                    $annotationText .= "\t\t\t\t'" . $key . "' => ['" . implode(", ", $valuesArray) . "'],\n";
                } else {
                    $annotationText .= "\t\t\t\t'" . $key . "' => '" . $value . "',\n";
                }
            }
            $annotationText .= "\t\t\t ]\n";

            fwrite($routeConfigFile, "\t\t [ \n");
            fwrite($routeConfigFile, "\t\t\t 'controller' => '" . $controllerText . "',\n");
            fwrite($routeConfigFile, "\t\t\t 'action' => '" . $actionText . "',\n");
            fwrite($routeConfigFile, "\t\t\t 'route' => '" . $routeText . "',\n");
            fwrite($routeConfigFile, $annotationText);

            fwrite($routeConfigFile, "\t\t ], \n");

        }

        fwrite($routeConfigFile, "\t ]; \n");
        fwrite($routeConfigFile, "}\n");
        fwrite($routeConfigFile, "?>");



        fclose($routeConfigFile);
    }

    private static function getRouteForMethod(ReflectionMethod $method)
    {
        $comments = $method->getDocComment();
        preg_match("/@Route\('(.+)\'\)/", $comments, $matches);
        if (count($matches) > 0) {
            return $matches[1];
        }

        return null;
    }

    private static function getAnnotationsForMethod(ReflectionMethod $method)
    {
        $annotations = [];
        $annotationsText = $method->getDocComment();
        preg_match_all("/@([a-zA-Z]+)\([\"\'](.+)[\"\']\)/m", $annotationsText, $matches);
        if (count($matches) > 0) {
            for ($i = 0; $i < count($matches[1]); $i++) {
                $key = strtolower($matches[1][$i]);
                $annotations[$key] = strtolower($matches[2][$i]);
            }
        }


        preg_match("/@Authorize/m", $annotationsText, $matches);
        if (count($matches) > 0) {
            $annotations['authorize'] = true;
        }

        if (count($annotations) > 0) {
            return $annotations;
        }

        return null;
    }
}