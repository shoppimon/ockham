<?php

/**
 * ockham
 *
 * @copyright (c) 2015 Shoppimon LTD
 * @author    shahar
 */

namespace Ockham\Adapter;

use Zend\Mail\Message;
use Zend\Mail\Transport\TransportInterface;
use Zend\Mail\Transport\Factory as TransportFactory;

/**
 * A Zend\Mail based "ticketing system" adapter.
 *
 * Really, this handles ticket creation by sending an email to a specified
 * address using the provided Zend\Mail transport. This could be useful
 * when:
 *
 * - You want to start simple, and maybe later switch to a 3rd party
 *   (possibly expensive) ticketing system
 *
 * - You want to integrate with a ticketing system that we have no adapter
 *   for, but supports creating tickets via email
 *
 * The following configuration options are supported:
 *
 *   ...
 *
 * @package Ockham\Adapter
 */
class ZendMail implements ServiceAdapter
{
    /**
     * @var TransportInterface
     */
    protected $transport;

    /**
     * @var string | array
     */
    protected $to;

    /**
     * @var string | array | null
     */
    protected $from;

    /**
     * @var string | null
     */
    protected $subjectPrefix;

    /**
     * Constructor for ticketing service adapter
     *
     * @param array $settings
     */
    public function __construct(array $settings)
    {
        $this->transport = TransportFactory::create($settings['transport']);
        $this->to = $settings['to'];
        $this->from = isset($settings['from']) ? $settings['from'] : null;
        $this->subjectPrefix = isset($settings['subject_prefix']) ? $settings['subject_prefix'] : null;
    }

    /**
     * Create a support ticket
     *
     * @param string $email
     * @param string $title
     * @param string $content
     * @param array  $attributes
     */
    public function createTicket($email, $title, $content, array $attributes = array())
    {
        if ($this->subjectPrefix) {
            $title = $this->subjectPrefix . ' ' . $title;
        }

        // Figure out to address
        $toEmail = null;
        $toName = null;
        if (is_array($this->to)) {
            $toEmail = $this->to[0];
            if (isset($this->to[1])) {
                $toName = $this->to[1];
            }
        } else {
            $toEmail = $this->to;
        }

        // Figure out from address
        $fromEmail = $email;
        $fromName = null;
        if ($this->from) {
            if (is_array($this->from)) {
                $fromEmail = $this->from[0];
                if (isset($this->from[1])) {
                    $fromName = $this->from[1];
                }
            } else {
                $fromEmail = $this->from;
            }
        }

        $message = new Message();
        $message->setSubject($title)
                ->addTo($toEmail, $toName)
                ->setFrom($fromEmail, $fromName)
                ->setReplyTo($email)
                ->setBody($content);

        $message->getHeaders()->addHeaderLine('content-type', 'text/plain; charset="UTF-8"');

        $this->transport->send($message);
    }
}
