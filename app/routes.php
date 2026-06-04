<?php

namespace App\Controllers;
use App\Controllers\ExampleController;
use App\Core\Router;

$router->get('', 'Controller@exibirLogin');
$router->get('login', 'Controller@index');