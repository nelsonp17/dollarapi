<?php

use App\Config\App;

require __DIR__ . '/vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('Resource/Views');
$twig = new \Twig\Environment($loader);

// iniciar la aplicación
$app = new App();
$app->run();

// rutas
require __DIR__ . '/router/web.php';