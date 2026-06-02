<?php

namespace App\Controllers;
use App\Controllers\ExampleController;
//use App\Controllers\UsuariosController;
use App\Core\Router;

$router->get('', 'ExampleController@index');

$router->get('crudUsuarios', 'UsuariosController@index');
$router->post('crudUsuarios/create', 'UsuariosController@store');