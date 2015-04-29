<?php

/**
 * ockham
 *
 * @copyright (c) 2015 Shoppimon LTD
 * @author    shahar
 */

namespace Ockham\Adapter;

interface ServiceAdapter
{
    /**
     * Constructor for ticketing service adapter
     *
     * @param array $settings
     */
    public function __construct(array $settings);

    /**
     * Create a support ticket
     *
     * @param string $email
     * @param string $title
     * @param string $content
     * @param array $attributes
     */
    public function createTicket($email, $title, $content, array $attributes = array());
}
