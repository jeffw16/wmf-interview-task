# wmf-interview-task
This is Jeffrey Wang's solution for the Wikimedia Foundation's Associate Engineer position's technical task.

## Prerequisites
* PHP
* Apache
* MySQL
* Composer

## Setup instructions
1. From this application's base directory, run `mysql -h $HOSTNAME -u $MYSQL_USER -p $MYSQL_PASS < includes/donations_schema.sql`.
2. Fill out the values of `settings_sample.php` and save them to `settings.php`.
3. Run `composer install && composer update` to install Composer dependencies.

## Testing instructions
After installing Composer, run `./vendor/bin/phpunit tests` from this application's base directory.

## Dependencies used
This uses the currency conversion library from https://github.com/ojhaujjwal/currency-converter-php.

This uses PHPUnit for unit testing.