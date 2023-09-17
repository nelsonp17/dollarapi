<?php

namespace App\Http\Middlewares;

class Middleware {
    public function handle($request, $next) {
        // Lógica del middleware antes de pasar al siguiente middleware o controlador

        // Verificar alguna condición o realizar alguna acción específica

        // Si es necesario, puedes modificar el $request antes de pasar al siguiente middleware o controlador
        // $request = ...

        // Llamar al siguiente middleware o controlador
        $response = $next($request);

        // Lógica del middleware después de pasar al siguiente middleware o controlador

        // Realizar alguna acción adicional en base al resultado de la respuesta

        return $response;
    }
}