<?php

namespace App\Http\Middlewares;

class AuthMiddleware extends Middleware
{
    public function handle($request, $next)
    {
        // Lógica de autenticación aquí
        // Si la autenticación falla, puedes redirigir a una página de inicio de sesión o mostrar un mensaje de error
        // Si la autenticación es exitosa, puedes permitir que el flujo continúe llamando al método parent::handle($request)
        
        if (self::isAuthenticated()) {
            return parent::handle($request, $next);
        } else {
            // Redirigir a la página de inicio de sesión o mostrar un mensaje de error
            //header("Location: https://www.google.co.ve/?gfe_rd=cr&ei=WTEJV6K0GYWZ-gXJrL2gDA&gws_rd=ssl");
            echo "error autenticacion";
            exit();
        }
    }

    private function isAuthenticated()
    {
        // Lógica de autenticación aquí
        // Retorna true si el usuario está autenticado, de lo contrario retorna false
        return true;
    }
}