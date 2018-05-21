<?php

namespace Adelf\Config;

abstract class Singletonable
{
    /**
     * Singletonable constructor.
     * Singleton class constructors can not be used.
     */
    private function __construct()
    {
    }

    /**
     * Get a singleton instance of class.
     *
     * @return $this
     */
    public static function instance()
    {
        static $instance = null;
        if (null === $instance) {
            $instance = new static();
            $instance->configure($instance);
        }

        return $instance;
    }

    /**
     * Singleton class initialization configuration.
     *
     * @param $instance
     *
     * @return mixed
     */
    protected function configure($instance)
    {
        return $instance;
    }
}
