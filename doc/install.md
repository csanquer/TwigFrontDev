Twig Front Dev
==============

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
      #you should use dev boostrap file by default 
      DirectoryIndex index_dev.php index.php index.html

      <Directory "<TwigFrontDev-path>/web">
        AllowOverride All
        Order allow,deny
        Allow from All
      </Directory>

    </VirtualHost>
    ```

* clear cache and dump assetic assets

    ```sh
    php src/console cache:clear
    php src/console assetic:dump --env=prod
    php src/console assetic:dump --env=dev
    ```