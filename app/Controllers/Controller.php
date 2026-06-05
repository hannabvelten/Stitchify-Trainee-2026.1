<?php

namespace App\Controllers;

use App\Core\App;
use Exception;

class Controller
{

    public function index()
    {
        return view('site/index');
    }
    public function exibirLogin()
    {
        return view('site/login');
    }
    public function exibirladingPage()
    {
        return view('site/landingpage');
    }
}