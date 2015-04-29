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

This will bring any required dependencies along as well.

Note that composer will set up the include path is required, so assuming you
don't already do so (usually your framework will), you need to `require`
composer's autoloader file from `vendor/autoload.php`

Usage
-----
TBD

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

