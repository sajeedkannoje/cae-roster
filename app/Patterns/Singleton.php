<?php

namespace App\Patterns;


/**
 *
 */
abstract class Singleton
{
    /**
     * @var Singleton|null
     */
    protected static ?Singleton $instance = null;

    /**
     * @return Singleton|null
     */
    public static function getInstance(): Singleton|static|null
    {
        if (null == static::$instance) {
            static::$instance = static::buildInstance();
        }

        return static::$instance;
    }

    /**
     * @return static
     */
    public static function buildInstance(): static
    {
        return new static();
    }
}
