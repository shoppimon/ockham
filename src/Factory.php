<?php

/**
 * ockham
 *
 * @copyright (c) 2015 Shoppimon LTD
 * @author    shahar
 */

namespace Ockham;

use Ockham\Adapter\ServiceAdapter;

class Factory
{
    static protected $registeredServices = [
        'mock'      => Adapter\Mock::class,
        'uservoice' => Adapter\UserVoice::class,
        'zendmail'  => Adapter\ZendMail::class
    ];

    /**
     * Register a new service adapter
     *
     * @param string $type
     * @param string $className
     *
     * @throws \ErrorException
     */
    public static function registerAdapter($type, $className)
    {
        if (! class_exists($className)) {
            throw new \ErrorException("Attempting to register an adapter class that does not exist: $className");
        }

        if (! is_subclass_of($className, ServiceAdapter::class)) {
            throw new \ErrorException(
                "Provided service adapter class does not implement the " . ServiceAdapter::class . " interface"
            );
        }

        static::$registeredServices[$type] = $className;
    }

    /**
     * Service adapter factory
     *
     * @param  string $type
     * @param  array  $settings
     *
     * @throws \ErrorException
     * @return ServiceAdapter
     */
    public static function createService($type, array $settings = array())
    {
        if (! isset(static::$registeredServices[$type])) {
            throw new \ErrorException("Unknown service adapter: $type");
        }

        $class = static::$registeredServices[$type];
        return new $class($settings);
    }
}
