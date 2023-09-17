<?php

use Router\Enrutador;

$router = new Enrutador();

// Definir rutas
$router->addRoute('GET', '/', function() {
    echo "¡Hola, esta es la página de inicio!";
});

$router->addRoute('GET', '/about', function() {
    echo "Esta es la página de acerca de nosotros";
});

$router->addRoute('POST', '/contact', function() {
    echo "Gracias por contactarnos";
});

// Manejar la solicitud actual
$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestPath = $_SERVER['REQUEST_URI'];

$router->handleRequest($requestMethod, $requestPath);

// Verificar el código de respuesta HTTP
$httpCode = http_response_code();

// Manejar diferentes errores
if($httpCode !== 200){
    if ($httpCode === 404) {
        include(error404);
    } elseif ($httpCode === 500) {
        include(error500);
    } else {
        // Manejar otros errores o mostrar una página genérica de error
        include(errorgeneric);
    }
}