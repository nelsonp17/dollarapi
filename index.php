<?php

use App\Config\App;
$vendor = require __DIR__ . '/vendor/autoload.php';

// iniciar la aplicación
$app = new App();
$app->run();

// rutas
require __DIR__ . '/router/web.php';