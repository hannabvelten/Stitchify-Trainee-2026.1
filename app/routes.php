<?php

namespace App\Controllers;
use App\Controllers\ExampleController;
use App\Controllers\PostsController;
use App\Core\Router;

$router->get('', 'ExampleController@index');
$router->get('tabelapost', 'PostsController@index');
$router->post('tabelapost/create', 'PostsController@store');