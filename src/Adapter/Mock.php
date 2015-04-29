<?php

/**
 * ockham
 *
 * @copyright (c) 2015 Shoppimon LTD
 * @author    shahar
 */

namespace Ockham\Adapter;

/**
 * The mock adapter does nothing. It serves three purposes:
 *
 *   1. To be used as a fallback when no other service is configured
 *   2. In testing
 *   3. Doing nothing is underestimated. It is important for us to make that
 *      statement by providing an adapter that does exactly that. If you
 *      disagree, you should go ahead and read Russel's "In Praise of Idleness"
 *      before doing any more programming work. Really. Here's a link:
 *      http://www.zpub.com/notes/idle.html
 *
 * Note that for testing purposes, you may pass an instance of a SplQueue
 * object as the value of the 'ticket_stack' key in the constructor $settings
 * array. This will get the Null adapter to push all "tickets" it creates into
 * that object, which you can later extract and inspect.
 *
 * @package Ockham\Adapter
 */
class Mock implements ServiceAdapter
{
    /**
     * @var \SplQueue
     */
    protected $ticketStack;

    /**
     * Constructor for ticketing service adapter
     *
     * @param array $settings
     */
    public function __construct(array $settings)
    {
        if (isset($settings['ticket_stack'])) {
            $this->ticketStack = $settings['ticket_stack'];
        }
    }

    /**
     * Create a support ticket
     *
     * @param string $email
     * @param string $title
     * @param string $content
     * @param array  $attributes
     *
     * @return mixed
     */
    public function createTicket($email, $title, $content, array $attributes = array())
    {
        if ($this->ticketStack instanceof \SplQueue) {
            $this->ticketStack->push([$email, $title, $content, $attributes]);
        }
    }
}
