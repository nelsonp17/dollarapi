<?php

namespace App\Http\Controllers\Utils;

class View{

    // metodos estaticos
    public static function view($ruta) {
        $viewPath = __DIR__ . '/../../Resource/Views/' . $ruta . '.php';
        
        if (file_exists($viewPath)) {
            include($viewPath);
        } else {
            echo "La vista no existe";
        }
    }
    public static function assets($src) {
        $viewPath = __DIR__ . '/../../Resource/public/' . $src;
        
        if (file_exists($viewPath)) {
            include($viewPath);
        } else {
            echo "El recurso no existe";
        }
    }
    public static function jsonResponse($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    public static function redirect($url) {
        header('Location: ' . base_url. $url);
        exit();
    }
    public static function to($nameRoute) {
        exit();
    }

}