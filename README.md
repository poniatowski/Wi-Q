wi-Q Backend Developer Test
==================================

# How to run #

Dependencies:

  * Run `docker-compose up -d`. This will initialise and start all the containers, then leave them running in the background.
  * Run `docker-compose exec php-fpm bash` and then `composer install` to install all relevant dependencies.
  
## Services exposed outside your environment ##


Service|Address outside
------|---------
Webserver|[localhost:8080](http://localhost:8080)

# How to run unit tests#
  * Run `docker-compose exec php-fpm bash` and then `./vendor/bin/phpunit` 