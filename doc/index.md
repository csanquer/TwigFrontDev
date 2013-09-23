Twig Front Dev
=================

a php application ready for building and designing Twig templates mockup

TwigFrontDev is built on top of [silex](http://silex.sensiolabs.org/) PHP micro-framework.

The following service providers are enabled :

* UrlGenerator Service Provider (add routing path and url function to twig)
* Translation Service Provider (add trans function to twig and translation file support)
* [Assetic Service Provider](https://github.com/mheap/Silex-Assetic) (add assetic functions to twig)
* Form Service Provider (add symfony2 form support to twig, only for skilled user with silex and symfony)

Requirements
------------

* a web server which supports virtual host and URL rewriting like [apache](http://httpd.apache.org/) or [nginx](http://nginx.org/)
* PHP >= 5.3.3
* [composer](http://getcomposer.org/) package manager 

recommended but _optional_

* PHP intl extension

Install 
-------

see [doc/index.md](https://github.com/csanquer/TwigFrontDev/blob/master/doc/install.md)

Usage
-----

see [doc/index.md](https://github.com/csanquer/TwigFrontDev/blob/master/doc/usage.md)