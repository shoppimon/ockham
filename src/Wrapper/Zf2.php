<?php

/**
 * ockham
 *
 * @copyright (c) 2015 Shoppimon LTD
 * @author    shahar
 */

namespace Ockham\Wrapper;

use Ockham\Factory;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * A Zend Framework 2.x Service Manager Factory wrapper for the Ockham\Factory
 *
 * This enables ZF2 users to use Ockham easily as a Service Manager managed
 * service without creating a stict dependency between Ockham and ZF2.
 *
 * To use, simply add the following service factory to one of your
 * application's existing modules (Ockham does not provide a ZF2 module of
 * its own):
 *
 *     'service_manager' => array(
 *       'factories' => array(
 *         'TicketingService' => 'Ockham\Wrapper\Zf2'
 *       )
 *     )
 *
 * In addition, add the following configuration to your module config, local.php
 * or any other config file included from your config/autoload.d:
 *
 *     'ockham' => array(
 *       'adapter' => 'uservoice',
 *       'settings' => array(
 *         // Adapter-specific key/value pairs of options
 *       )
 *     )
 *
 * Please note that if your configuration will not be set, or the 'adapter' key
 * will not be set, the factory will default to creating a Null adapter. If
 * you do specify the adapter, but forget some required configuration option or
 * provide malformed configuration, the specific adapter might throw an exception.
 *
 * @package Ockham\Wrapper
 */
class Zf2 implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');
        if (isset($config['ockham']) && isset($config['ockham']['adapter'])) {
            $config = $config['ockham'];
        } else {
            $config = ['adapter' => 'null'];
        }

        if (! isset($config['settings'])) {
            $config['settings'] = [];
        }

        return Factory::createService($config['adapter'], $config['settings']);
    }
}
