Twig Front Dev
==============

Usage
-------

* define your mockup pages :

  edit the config/pages.yml and add a new page with a route , an url and a template (to create in the views directory).

  example : a template to display a book, at the url /book/{id}, with the silex route book_show, 
  with a html twig template in views/book/show.html.twig and with an array "book" variable available in the template.

  The route id parameter will be available as a twig variable in the template

    ```yml
    pages:
      book_show:
        url: /book/{id}
        template: book/show.html.twig 
        variables:
          book:
            title: book 1 title
            summary: book 1 title
    ```

* clear the cache and dumps assets by assetic if needed :

    ```sh
    php src/console cache:clear
    php src/console assetic:dump --env=prod
    php src/console assetic:dump --env=dev
    ```

* browse to the TwigFrontDev homepage , new pages link will be available