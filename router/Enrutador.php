<?php 

namespace Router;

class Enrutador {
    private $routes = [];

    public function addRoute($method, $path, $callback) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'callback' => $callback
        ];
    }

    public function handleRequest($method, $path) {
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $route['path'] === $path) {
                $callback = $route['callback'];
                $callback();
                return;
            }
        }

        // Si no se encuentra ninguna ruta coincidente, puedes mostrar una página de error o redirigir a una ruta predeterminada.
        header("HTTP/1.0 404 Not Found");
    }
}