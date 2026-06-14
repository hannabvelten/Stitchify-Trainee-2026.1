<?php

namespace App\Controllers;
use App\Controllers\ExampleController;
use App\Controllers\PostsController;
use App\Core\Router;

$router->get('', 'ExampleController@index');

$router->get('', 'PostsController@index');

$router->get('tabelapost', 'PostsController@index');
$router->post('tabelapost/create', 'PostsController@store');
// Rotas para editar e excluir posts
$router->post('tabelapost/update', 'PostsController@update');
$router->post('tabelapost/delete', 'PostsController@destroy');


$router->get('landing-page', 'PostsController@landingPage');
$router->get('Post-individual', 'PostsController@postIndividual');