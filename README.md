# OMDB Test

## Requirements
* [PHP](https://php.net) >= 7.1
* PHP cURL extension
* MySQL
* [Composer](https://getcomposer.org)

## Installation
* Install dependencies
`composer install`
* [OMDB](http://www.omdbapi.com/) API key
```php
// index.php
$omdbKey = '';
```
* DB config
```php
// /models/Mapper/Db.php
$db = [
    'driver' => 'pdo_mysql',
    'user' => 'test',
    'password' => '',
    'host' => '127.0.0.1',
    'port' => '3306',
    'dbname' => 'omdb',
        ];
```
* Create DB tables
`vendor/bin/doctrine orm:schema-tool:update --force --dump-sql`
