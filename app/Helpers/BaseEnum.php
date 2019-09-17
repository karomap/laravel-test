<?php

namespace App\Helpers;

abstract class BaseEnum
{
    /**
     * Constant storage.
     *
     * @var array
     */
    protected static $constants = [];

    /**
     * Get enum constants.
     *
     * @return array
     */
    public static function getConstants()
    {
        $class = get_called_class();
        if (!isset(static::$constants[$class])) {
            static::$constants[$class] = (new \ReflectionClass(get_called_class()))->getConstants();
        }

        return static::$constants[$class];
    }
}
