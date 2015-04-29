<?php

/**
 * ockham
 *
 * @copyright (c) 2015 Shoppimon LTD
 * @author    shahar
 */

namespace Ockham\Adapter;

use UserVoice\Client;

class UserVoice implements ServiceAdapter
{
    /**
     * @var \UserVoice\Client
     */
    protected $client;

    /**
     * Constructor for ticketing service adapter
     *
     * @param array $settings
     */
    public function __construct(array $settings)
    {
        $this->client = new Client(
            $settings['subdomain'],
            $settings['api_key'],
            $settings['api_secret'],
            isset($settings['options']) ? $settings['options'] : array()
        );
    }

    /**
     * Create a support ticket
     *
     * @param string $email
     * @param string $title
     * @param string $content
     * @param array  $attributes
     *
     * @throws \ErrorException
     * @return integer new ticket ID
     */
    public function createTicket($email, $title, $content, array $attributes = array())
    {
        $response = $this->client->post("/api/v1/tickets.json", array(
            'email' => $email,
            'ticket' => array(
                'state' => 'open',
                'subject' => $title,
                'message' => $content,
            )
        ));
        if (isset($response['ticket']) && isset($response['ticket']['id'])) {
            return $response['ticket']['id'];
        } else {
            throw new \ErrorException("Ticket was not created successfully");
        }
    }
}
