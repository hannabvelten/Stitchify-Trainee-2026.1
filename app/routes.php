<?php

namespace App\Controllers;
use App\Controllers\ExampleController;
use App\Controllers\PostsController;
//use App\Controllers\UsuariosController;
use App\Core\Router;

$router->get('login', 'Controller@exibirLogin');
$router->get('inscreva-se', 'Controller@exibirInscrevaSe');
$router->get('landingpage', 'Controller@exibirlandingPage');
$router->post('login', 'Controller@efetuaLogin');
$router->post('inscreva-se', 'Controller@efetuaInscricao');


$router->get('', 'PostsController@index');

$router->get('tabelapost', 'PostsController@index');
$router->post('tabelapost/create', 'PostsController@store');
// Rotas para editar e excluir posts
$router->post('tabelapost/update', 'PostsController@update');
$router->post('tabelapost/delete', 'PostsController@destroy');


$router->get('landing-page', 'PostsController@landingPage');
$router->get('Post-individual', 'PostsController@postIndividual');
$router->get('lista-de-posts', 'PostsController@posts');

$router->get('crudUsuarios', 'UsuariosController@index');

$router->get('crudUsuarios', 'UsuariosController@index');
$router->post('crudUsuarios/create', 'UsuariosController@store');
$router->post('crudUsuarios/edit', 'UsuariosController@edit');
$router->post('crudUsuarios/delete', 'UsuariosController@delete');