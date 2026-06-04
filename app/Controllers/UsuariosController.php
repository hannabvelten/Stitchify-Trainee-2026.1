<?php

namespace App\Controllers;

use App\Core\App;
use Exception;

class UsuariosController
{

    public function index()
    {
        $usuarios = App::get('database')->selectAll('usuarios');

        return view('admin/crudUsuarios', compact('usuarios'));
    }
    public function store()
    {
        $parameters = [
            'nome' => $_POST['nome'],
            'email' => $_POST['email'],
            'senha'  => $_POST['senha'],
            'tipo'  => 'usuario'
        ];

        App::get('database')->insert('usuarios', $parameters);

        header('Location: /crudUsuarios');

    }

    public function edit()
    {
        $parameters = [
            'nome' => $_POST['nome'],
            'email' => $_POST['email'],
            'senha'  => $_POST['senha'],
            'tipo'  => 'usuario'
        ];

        $id = $_POST['id'];

        App::get('database')->update('tabela_usuarios', $id, $parameters);

        header('Location: /crudUsuarios');
    }

    public function delete()
    {
        $id = $_POST['id'];

        App::get('database')->delete('tabela_usuarios', $id);

        header('Location: /crudUsuarios');
    }
}