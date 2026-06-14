<?php

namespace App\Controllers;
use App\Controllers\ExampleController;
use App\Core\Router;

$router->get('login', 'Controller@exibirLogin');
$router->get('inscreva-se', 'Controller@exibirInscrevaSe');
$router->get('landingpage', 'Controller@exibirlandingPage');
$router->post('login', 'Controller@efetuaLogin');
$router->post('inscreva-se', 'Controller@efetuaInscricao');
