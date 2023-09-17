<?php

use Dotenv\Dotenv;

$vendor = require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable (__DIR__."/../");
$dotenv->load();


// Definiendo las variables del sistema
define('prod', boolval($_ENV['prod']));

define('db_host', (prod==true) ? $_ENV['database_prod_host'] : $_ENV['database_dev_host'] );
define('db_name', (prod==true) ? $_ENV['database_prod_name'] : $_ENV['database_dev_name'] );
define('db_user', (prod==true) ? $_ENV['database_prod_user'] : $_ENV['database_dev_user'] );
define('db_password', (prod==true) ? $_ENV['database_prod_password'] : $_ENV['database_dev_password'] );
define('base_url', (prod==true) ? $_ENV['base_url_prod'] : $_ENV['base_url_dev'] );

// Page error Handle
define("error404", "Views/errorPage/404.php");
define("error500", "Views/errorPage/500.php");
define("errorgeneric", "Views/errorPage/generic.php");