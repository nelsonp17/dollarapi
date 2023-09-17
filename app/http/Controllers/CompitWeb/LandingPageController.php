<?php

namespace App\Http\Controllers\CompitWeb;

use App\Http\Controllers\Controller;

class LandingPageController extends Controller{
    
    public function index()
    {
        $this->render("compitWeb/index", ['name'=> 'Nelson Portillo']);
    }
}