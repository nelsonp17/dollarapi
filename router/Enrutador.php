<?php 

namespace Router;

class Enrutador {
    private $routes = [];
    private $routeGroups = [];
    private $itemGroups = [];
    private $group = false;

    public function group($prefix, $callback) {
        $this->group = true;
        // Llamar al callback del grupo
        $callback(); 

        // Recorrer las rutas del grupo y agregarlas al enrutador actual
        foreach ($this->itemGroups as $route) {
            $method = $route['method'];
            $path = $prefix . $route['path'];
            $callback = $route['callback'];
            $this->addRoute($method, $path, $callback);
        }
        $this->itemGroups = [];
        $this->group = false;
    }

    public function addRoute($method, $path, $callback) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'callback' => $callback
        ];
    }
    public function addItemGroup($method, $path, $callback){
        $this->itemGroups[] = [
            'method' => $method,
            'path' => $path,
            'callback' => $callback
        ];
    }

    public function get($path, $callback){
        if($this->group === false){
            $this->addRoute('GET', $path, $callback);
        }else{
            $this->addItemGroup('GET', $path, $callback);
        }
        
    }

    public function post($path, $callback){
        if($this->group === false){
            $this->addRoute('POST', $path, $callback);
        }else{
            $this->addItemGroup('POST', $path, $callback);
        }
    }

    public function put($path, $callback){
        if( $this->group === false){
            $this->addRoute('PUT', $path, $callback);
        }else{
            $this->addItemGroup('PUT', $path, $callback);
        }
    }

    public function delete($path, $callback){
        if($this->group === false){
            $this->addRoute('DELETE', $path, $callback);
        }else{
            $this->addItemGroup('DELETE', $path, $callback);
        }
    }

    public function patch($path, $callback){
        if( $this->group === false){
            $this->addRoute('PATCH', $path, $callback);
        }else{
            $this->addItemGroup('PATCH', $path, $callback);
        }
    }


    

    function handleRequest($method, $path) {
        $matchedRoute = null;
    
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
}

