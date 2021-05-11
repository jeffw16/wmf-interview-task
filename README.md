# wmf-interview-task
This is Jeffrey Wang's solution for the Wikimedia Foundation's Associate Engineer position's technical task.

## Prerequisites
* PHP
* Apache
* MySQL
* Composer

## Setup instructions
1. From this application's base directory, run `mysql -h $HOSTNAME -u $MYSQL_USER -p $MYSQL_PASS < includes/donations_schema.sql`.
2. Fill out the values of `settings_sample.php`.
3. Move `settings_sample.php` to `settings.php`.
4. Run `composer update` to install Composer dependencies.

## Dependencies used
This uses the currency conversion library from https://github.com/ojhaujjwal/currency-converter-php.