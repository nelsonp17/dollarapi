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


$router->group('/api', function() use ($router)  {

    $router->get('/users', function() {
        echo "Esta es la página de usuarios";
    });
    $router->get('/user/{id}', function($matches) {
        $userId = $matches[1]; 
        echo "Usuario: ". $userId;
    });

    $router->post('/users', function() {
        echo "Esta es la página de usuarios (POST)";
    });
});


/**
 * 
 * $router->group('/api', function() use ($router) {
 *     $router->get('/users', 'UserController@index');
 *     $router->post('/users', 'UserController@store');
 *     // ... otras rutas relacionadas con usuarios
 * });
 * 
 * $router->group('/admin', function() use ($router) {
 *     $router->get('/dashboard', 'AdminController@dashboard');
 *     $router->get('/users', 'AdminController@users');
 *     // ... otras rutas relacionadas con la administración
 * });
 */

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