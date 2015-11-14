<?php

namespace RedDevil\Core;

class BindingModelMapper {

    public static function mapBindingModels($controller, $action)
    {

        $generatedBindingModels = [];

        $class = new \ReflectionClass($controller);
        $method = $class->getMethod($action);
        $properties = $method->getParameters();
        foreach ($properties as $property) {
            if (gettype($property) == 'object') {
                $bindingModelClass = $property->getClass();

                $bmClassName = $property->getClass()->name;
                $bindingModelInstance = new $bmClassName();

                if (!HttpContext::getInstance()->isPost()) {
                    $generatedBindingModels[] = $bindingModelInstance;
                    continue;
                }

                $methods = $bindingModelClass->getMethods();
                foreach ($methods as $bmMethod) {
                    if (strpos($bmMethod->name, 'set') === 0) {
                        $propertyName = lcfirst(substr($bmMethod->name, 3, strlen($bmMethod->name)));
                        if (isset($_POST[$propertyName])) {
                            $method = $bmMethod->name;
                            $bindingModelInstance->$method($_POST[$propertyName]);
                        }
                    }
                }

                $bindingModelInstance->validate();
                $generatedBindingModels[] = $bindingModelInstance;
            }
        }

        return $generatedBindingModels;
    }
}