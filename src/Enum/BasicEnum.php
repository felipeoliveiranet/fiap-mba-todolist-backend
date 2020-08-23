<?php /** @noinspection PhpMissingFieldTypeInspection */

namespace App\Enum;

use Exception;
use ReflectionClass;
use ReflectionException;

abstract class BasicEnum {

    private static $constCacheArray = NULL;

    private static function getConstants() {

        if (self::$constCacheArray == NULL) {

            self::$constCacheArray = [];
        }

        $calledClass = get_called_class();

        if (!array_key_exists($calledClass, self::$constCacheArray)) {

            try {
                $reflect = new ReflectionClass($calledClass);

            } catch (ReflectionException $e) {

                return new Exception("Fail to validate enum parameters");
            }

            self::$constCacheArray[$calledClass] = $reflect->getConstants();
        }

        return self::$constCacheArray[$calledClass];
    }

    public static function isValid($name, $returnValue = false) {

        $return = false;

        try {

            $constants = self::getConstants();

        } catch (Exception $e) {

            return new Exception("Fail to validate enum parameters");
        }

        if(array_key_exists($name, $constants)) {

            $return = true;

            if($returnValue)
                $return = $constants[$name];

        } else {
           $return = self::isValidValue($name, $returnValue);
        }

        return $return;
    }

    private static function isValidValue($value, $returnValue = false) {

        $values = array_values(self::getConstants());

        if(in_array($value, $values))
            return $value;
    }
}