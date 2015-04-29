Ockham - a PHP abstraction layer for 3rd party support / ticketing systems
==========================================================================

Ockham is a minimal abstraction layer, wrapping different APIs to 3rd party
support ticketing systems. Its purpose is not to provide the full functionality
one would expect from a ticketing system API, but rather a "lowest common
denominator" implementation of what most apps need when integrating with a
ticketing system - i.e. creating tickets, and possibly a few more actions,
but not more than that.

Installation
------------
Ockham is available via [Composer](http://getcomposer.org/). Add it to your
project by running the following composer command on your project root:

    $ composer require shoppimon/ockham

In addition, most service adapter implementations need to be required
explicitly (they are only suggested by the composer package and not required
because most people won't use all of them). So, you need to require the
specific underlying library(ies) as well, for example:

    $ composer require uservoice/uservoice

This will bring any required dependencies along as well.

Note that composer will set up the include path is required, so assuming you
don't already do so (usually your framework will), you need to `require`
composer's autoloader file from `vendor/autoload.php`

Implemented Adapters
--------------------

 * `uservoice` - Create tickets on [uservoice.com](http://uservoice.com)
   requires the `uservoice/uservoice` composer package
 * `zendmail` - "Create a ticket" by sending an email to a given address using
   the Zend\Mail ZF2 component.
   requires the `zendframework/zend-mail` composer package
 * `mock` - A mock implementation, doesn't really do anything and has no
   requirements; Should be used for testing purposes only.

Usage
-----
Once installed, you can use the Factory method to get an instance of the
required backend class:

    use Ockham\Factory;

    $options = array(
        'transport' => array(
            'type' => 'smtp',
            'options' => array()
        ),
        'to' => array('feedback@shoppimon.com', 'Shoppimon Support'),
        'from' => array('do-not-reply@shoppimon.com'),
        'subject_prefix' => '[Support Request]'
    );
    $ticketService = Factory::createService('zendmail', $options);
    $ticketService->createTicket('noob@example.com', 'I need help!', $message);

Some additional options and functionality is documented in the code (for now,
sorry).

Framework Wrappers
------------------
It is our goal to ship Ockham with no stict dependancies on any PHP Framework.
That said, we aim to ship some optional "Framework Wrappers" that wrap the
Factory class with some framework-specific service provider API.

Currently, Zend Framework 2 users can use the `Ockham\Wrapper\Zf2` class as
a Service Manager Factory to easily provide Ockham as an app-wide service. See
the class PHPDoc comment for details.

Contributing, TODO
------------------
You can contribute by forking the project's canonical repo and sending out
pull requeusts. The following is a non-comprehensive TODO list:

 * Unit tests
 * Documentation
 * Create additional adapters (e.g. ZenDesk, more mail adapters)

Copyright
---------
(c) 2015 Shoppimon LTD, all rights reserved.

Ockham is an open-source project released by the development team of
[Shoppimon](https://www.shoppimon.com), under the MIT license.

