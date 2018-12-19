<?php
define('HOME_URL', 'http://localhost/php-mvc');
define('HOME_URL_SSL', 'https://localhost/php-mvc');

define('ROOT_URL', dirname(__FILE__));
define('DEBUG', true);

define('DB_TYPE', 'mysqli');
define('CONNECT_DB', false);

define('AUTH_KEY', md5('anyrandomstring'));

define('MYSQLI_DB_HOST', '127.0.0.1');
define('MYSQLI_DB_USER', 'username');
define('MYSQLI_DB_PASS', 'password');
define('MYSQLI_DB_NAME', 'dbname');
?>