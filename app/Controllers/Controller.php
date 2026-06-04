<?php

namespace App\Controllers;

use App\Core\App;
use Exception;

class ExampleController
{

    public function index()
    {
        return view('site/index');
    }
    public function exibirLogin{
        return view(name: 'admin/login');
    }
}