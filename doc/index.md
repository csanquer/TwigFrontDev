Twig Front Dev
=================

a php application ready for building and designing Twig templates mockup

TwigFrontDev is basically built on top of [silex](http://silex.sensiolabs.org/) PHP micro-framework.

Requirements
------------

* a web server which supports virtual host and URL rewriting like [apache](http://httpd.apache.org/) or [nginx](http://nginx.org/)
* PHP >= 5.3.3
* [composer](http://getcomposer.org/) package manager 

recommended but _optional_

* PHP intl extension

Install
-------

* get TwigFrontDev sources and remove git metadata :

  * by git

    ```sh
    git clone https://github.com/csanquer/TwigFrontDev.git <path>
    cd <path>
    rm -rf .git
    ```

  * or by composer (don't forget to respond yes to the remove VCS information dialog during installation)

    ```sh
    php composer.phar create-project --stability=dev csanquer/twig-front-dev <path>
    ```

* copy sample config file and edit it with your environment parameters

    ```sh
    cd <path>
    cp config/config.yml.dist config/config.yml
    ```

* create a vhost for TwigFrontDev ( see [http://silex.sensiolabs.org/doc/web_servers.html](http://silex.sensiolabs.org/doc/web_servers.html) )
    the document root must target the web directory
    and you must set a local hostname in /etc/hosts if you work on your local machine

    apache 2 with php module example :

    ```
    <VirtualHost *:80>
      ServerName <your-local-hostname>

      DocumentRoot "<TwigFrontDev-path>/web"
      DirectoryIndex index.php index.html

      <Directory "<TwigFrontDev-path>/web">
        AllowOverride All
        Order allow,deny
        Allow from All
      </Directory>

    </VirtualHost>
    ```

* clear cache

    ```sh
    php src/console cache:clear
    ```