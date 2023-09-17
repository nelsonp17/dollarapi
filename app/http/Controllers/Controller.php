<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Utils\View;

class Controller {
    protected $request;

    public function __construct($request=null) {
        $this->request = $request;
    }

    public function render($route, $param = []) {
        //View::view($ruta);
        View::render($route, $param);
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