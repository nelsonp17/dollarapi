<?php

    /**public function handleRequest($method, $path) {
    *    foreach ($this->routes as $route) {
    *        if ($route['method'] === $method && $route['path'] === $path) {
    *            $callback = $route['callback'];
    *            if (is_callable($callback)) {
    *                // Si el callback es una función, llámala directamente
    *                $callback();
    *            } elseif (is_string($callback) && strpos($callback, '@') !== false) {
    *                // Si el callback es una cadena en formato "Clase@metodo", crea una instancia de la clase y llama al método
    *                list($class, $method) = explode('@', $callback);
    *                $instance = new $class();
    *                $instance->$method();
    *            }
    *            return;
    *        }
    *    }
    *    // Si no se encuentra ninguna ruta coincidente, puedes mostrar una página de error o redirigir a una ruta predeterminada.
    *    header("HTTP/1.0 404 Not Found");
    }**/


        /* public function group($prefix, $callback) {
        $this->routeGroups[] = [
            'prefix' => $prefix,
            'callback' => $callback
        ];

        var_dump($this->routeGroups);
        echo "<br><br>";
    } */

    /**public function group($prefix, $callback) {
        echo "prefix: ". $prefix. "<br>";
        $router = $this; // Obtener una referencia al enrutador actual
        $groupRouter = new Enrutador(); // Crear una nueva instancia de enrutador para el grupo
        $callback($groupRouter); // Llamar al callback del grupo y pasarle el enrutador del grupo
        
        var_dump($callback);
        echo "<br>";
        // Recorrer las rutas del grupo y agregarlas al enrutador actual
        foreach ($groupRouter->routes as $route) {
            $method = $route['method'];
            $path = $prefix . $route['path'];
            $callback = $route['callback'];
            echo "path: ".$path. "<br>";
            $this->addRoute($method, $path, $callback);
        }

        echo "<br><br>";
    }**/


    //$trimmedPath = substr($path, strlen($prefix));
                //if (is_callable($callback)) {
                //    $callback($trimmedPath);
                //} else {
                //    $this->handleGroupRequest($callback, $trimmedPath);
                //}
                //echo $trimmedPath."<br>";
                //echo "hola <br>";