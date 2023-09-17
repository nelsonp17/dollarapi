<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Utils\View;

class Controller {
    protected $request;

    public function __construct($request) {
        $this->request = $request;
    }

    public function view($ruta) {
        View::view($ruta);
    }
    public function jsonResponse($data) {
        View::jsonResponse($data);
    }
    public function redirect($url) {
        View::redirect($url);
    }
    public function to($nameRoute) {
        View::to($nameRoute);
    }
}