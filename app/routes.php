<?php

namespace App\Controllers;
use App\Controllers\ExampleController;
use App\Core\Router;

$router->get('login', 'Controller@exibirLogin');
$router->get('landingpage', 'Controller@exibirlandingPage');
$router->post('login', 'Controller@efetuaLogin');