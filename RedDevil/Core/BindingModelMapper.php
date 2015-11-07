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

                $methods = $bindingModelClass->getMethods();
                foreach ($methods as $bmMethod) {
                    if (strpos($bmMethod->name, 'set') === 0) {
                        $propertyName = strtolower(substr($bmMethod->name, 3, strlen($bmMethod->name)));
                        if (!isset($_POST[$propertyName])) {
                            throw new \Exception('Invalid binding model supplied to ' . $class->name . '.');
                        }
                        $method = $bmMethod->name;
                        $bindingModelInstance->$method($_POST[$propertyName]);
                    }
                }

                $generatedBindingModels[] = $bindingModelInstance;
            }
        }

        return $generatedBindingModels;
    }
}