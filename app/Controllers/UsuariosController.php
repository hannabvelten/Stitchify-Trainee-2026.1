<?php

namespace App\Controllers;

use App\Core\App;
use Exception;

class UsuariosController
{

    public function index()
    {
        $usuarios = App::get('database')->selectAll('tabela_usuarios');

        return view('admin/crudUsuarios', compact('tabela_usuarios'));
    }
    public function store()
    {   
        $foto = 'default-avatar.png';
    
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $foto = $_FILES['foto']['name']; 
    }
        $parameters = [
            'nome' => $_POST['nome'],
            'email' => $_POST['email'],
            'senha'  => $_POST['senha'],
            'tipo'  => 'usuario',
            'foto'  => $foto
        ];

        App::get('database')->insert('tabela_usuarios', $parameters);

        header('Location: /crudUsuarios');

    }
}