<?php

use Router\Router;
use App\Http\Middlewares\Middleware;
use App\Http\Middlewares\AuthMiddleware;

$router = new Router();
/*
// Middleware para autenticación
$router->addMiddleware(function() {
    // Lógica para verificar la autenticación del usuario
    if (!isLoggedIn()) {
        header("HTTP/1.0 401 Unauthorized");
        echo "No estás autenticado";
        exit();
    }
});

// Ruta protegida por autenticación
$router->get('/profile', function() {
    echo "Bienvenido a tu perfil";
});
*/

// Definir rutas
$router->get('/', 'App\Http\Controllers\CompitWeb\LandingPageController@index');

$router->addRoute('GET', '/about', function() {
    echo "Esta es la página de acerca de nosotros";
})->middleware(function() {
    // Lógica del middleware para la ruta '/api/users'
    echo "Este es un middleware para la ruta de usuarios de la API <br>";
});

//$router->addRoute('POST', '/contact', function() {
//    echo "Gracias por contactarnos";
//});


$router->group('/api/dollar', function() use ($router)  {
    $router->get('/current', 'App\Http\Controllers\DollarSale\ApiController@vercel');
});
$router->group('/api', function() use ($router)  {
    $router->get('/twitter', 'App\Http\Controllers\Twitter\ApiController@run');
});

$router->group('/api', function() use ($router)  {

    

    $router->get('/users', function() {
        echo "Esta es la página de usuarios";
    })->middleware(function() {
        // Lógica del middleware para la ruta '/api/users'
        echo "Este es un middleware para la ruta de usuarios de la API <br>";
    });

    $router->get('/users2', function() {
        echo "Esta es la página de usuarios";


    })->middleware(AuthMiddleware::class);
    

    $router->get('/user/{id}', function($matches) {
        $userId = $matches[1]; 
        echo "Usuario: ". $userId;
    });

    $router->post('/users', function() {
        echo "Esta es la página de usuarios (POST)";
    });
});

// Obtener la ruta por su nombre
//$route = $router->getRouteByName('home');
//echo "La ruta de la página de inicio es: " . $route;

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

// agregar un middleware global
$router->addMiddleware(Middleware::class);
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