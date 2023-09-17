<?php 

namespace Router;

class Router {
    private $routes = [];
    private $itemGroups = [];
    private $group = false;
    private $middlewares = [];
    private $method1Called = false;
    private $middlewareGroup = null;

    public function group($prefix, $callback) {
        $this->group = true;
        // Llamar al callback del grupo
        $callback(); 

        // Recorrer las rutas del grupo y agregarlas al enrutador actual
        foreach ($this->itemGroups as $route) {
            $method = $route['method'];
            $path = $prefix . $route['path'];
            $callback = $route['callback'];
            $name = (isset($route['name'])) ? $route['name'] : null;
            $middlewares = $route['middlewares'];
            
            $this->addRoute($method, $path, $callback, $name, $middlewares);
        }
        $this->itemGroups = [];
        $this->group = false;
        return $this; // Retorna la instancia de la clase
    }

    public function addRoute($method, $path, $callback, $name = null, $middleware = null) {
        $middlewares = [];

        foreach ($this->routes as &$route) {
            if ($route['path'] === $path) {
                $middlewares = $route['middlewares'];
                break;
            }
        }
        if($middleware!=null){
            $middlewares = $middleware;
        }
        
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'callback' => $callback,
            'name' => $name,
            'middlewares' => $middlewares
        ];

        $this->method1Called = true;
        return $this; // Retorna la instancia de la clase
    }
    public function addMiddleware($callback) {
        $this->middlewares[] = $callback;
        $this->method1Called = true;
        return $this; // Retorna la instancia de la clase
    }

    public function middleware($middleware) {
        if ($this->method1Called) {
            // Lógica del método
        } else {
            //method2 debe ser llamado después de method1
        }
        if($this->middlewareGroup!=null){
            foreach ($this->itemGroups as &$route) {
                if ($route['path'] === $this->middlewareGroup) {
                    $route['middlewares'][] = $middleware;
                    break;
                }
            }

            $this->middlewareGroup = null;
        }else{
            // Agregar el middleware a la última ruta agregada
            $lastRouteIndex = count($this->routes) - 1;
            $this->routes[$lastRouteIndex]['middlewares'][] = $middleware;

            $this->method1Called = true;
        }

        return $this; // Devolver el objeto enrutador para permitir el encadenamiento de métodos
    }
    /*private function executeMiddlewares() {
        foreach ($this->middlewares as $middleware) {
            $middleware();
        }
    }*/

    public function addItemGroup($method, $path, $callback, $name = null, $middleware=null){
        $middlewares = [];

        foreach ($this->itemGroups as &$route) {
            if ($route['path'] === $path) {
                $middlewares = $route['middlewares'];
                break;
            }
        }
        if($middleware!=null){
            $middlewares[] = $middleware;
        }

        $this->itemGroups[] = [
            'method' => $method,
            'path' => $path,
            'callback' => $callback,
            'middlewares' => $middlewares
        ];
    }

    private function methodStruct($method, $path, $callback, $name = null, $middleware=null){
        if($this->group === false){
            $this->addRoute($method, $path, $callback, $name, $middleware);
        }else{
            $this->addItemGroup($method, $path, $callback, $name, $middleware);
            $this->middlewareGroup = $path;
        }

        $this->method1Called = true;
        return $this; // Retorna la instancia de la clase
    }

    public function get($path, $callback, $name = null, $middleware=null){
        return $this->methodStruct("GET", $path, $callback, $name, $middleware);
    }

    public function post($path, $callback, $name = null, $middleware=null){
        return $this->methodStruct("POST", $path, $callback, $name, $middleware);
    }

    public function put($path, $callback, $name = null, $middleware=null){
        return $this->methodStruct("PUT", $path, $callback, $name, $middleware);
    }

    public function delete($path, $callback, $name = null, $middleware=null){
        return $this->methodStruct("DELETE", $path, $callback, $name, $middleware);
    }

    public function patch($path, $callback, $name = null, $middleware=null){
        return $this->methodStruct("PATCH", $path, $callback, $name, $middleware);
    }

    public function getRouteByName($name) {
        foreach ($this->routes as $route) {
            if ($route['name'] === $name) {
                return $route['path'];
            }
        }
        return null;
    }


    function handleRequest($method, $path) {
        // Ejecutar los middlewares globales antes de manejar las rutas
        $this->executeMiddlewares($this->middlewares);

        $matchedRoute = null;

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $route['path'] === $path) {
                // Ejecutar los middlewares específicos de la ruta antes de manejar la ruta
                
                //echo "<br>";
                //var_dump($route['middlewares']);
                //echo "<br>";
                //echo "<br>";

                $this->executeMiddlewares($route['middlewares']);
                break;
            }
        }
    
        foreach ($this->routes as $route) {
            $routePath = $route['path'];
    
            // Verificar si la ruta tiene parámetros
            if (strpos($routePath, '{') !== false) {
                // Convertir la ruta con parámetros en una expresión regular
                $regex = preg_replace('/{([^\/]+)}/', '([^/]+)', $routePath);
                $regex = '#^' . $regex . '$#';
    
                // Verificar si la URL coincide con la expresión regular
                if (preg_match($regex, $path, $matches)) {
                    $matchedRoute = $route;
                    // Pasar los valores de los parámetros a la función de devolución de llamada
                    $route['callback']($matches);
                    break;
                }
            } 
            /*else {
                // Verificar si la ruta coincide exactamente con la URL
                if ($routePath === $path) {
                    $matchedRoute = $route;
                    $route['callback']();
                    break;
                }
            }*/
        }

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $route['path'] === $path) {
                $callback = $route['callback'];
                $this->executeCallback($callback);
                $matchedRoute = $route;
            }
        }
        // Si no se encuentra ninguna ruta coincidente, puedes mostrar una página de error o redirigir a una ruta predeterminada.
        //header("HTTP/1.0 404 Not Found");
        if (!$matchedRoute) {
            // Si no se encuentra ninguna ruta coincidente, puedes mostrar una página de error o redirigir a una ruta predeterminada.
            header("HTTP/1.0 404 Not Found");
        }
    }

    private function executeCallback($callback, $path = null) {
        if (is_callable($callback)) {
            //echo "hola mundo <br>";
            // Si el callback es una función, llámala directamente
            $callback($path);
        } elseif (is_string($callback) && strpos($callback, '@') !== false) {
            // Si el callback es una cadena en formato "Clase@metodo", crea una instancia de la clase y llama al método
            list($class, $method) = explode('@', $callback);
            $instance = new $class();
            $instance->$method($path);
        }
    }


    private function executeMiddlewares($middlewares) {
        $request = $_SERVER['REQUEST_METHOD']; // REQUEST_URI o REQUEST_METHOD
        $next = function ($request) {
            // Implementa aquí la lógica para llamar al siguiente middleware o controlador
        };

        foreach ($middlewares as $middleware) {
            //$middleware();

            if (is_callable($middleware)) {
                $middleware();
            } else{
                $middlewareInstance = new $middleware();
                $response = $middlewareInstance->handle($request, $next);
            }
        }
    }


    
}

