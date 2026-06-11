<?php

namespace App\Controllers;

use App\Core\App;
use Exception;

class UsuariosController
{

    public function index()
    {
        $usuarios = App::get('database')->selectAll('tabela_usuarios');

        return view('admin/crudUsuarios', compact('usuarios'));

        $textoBusca = isset($_GET('busca')) ? $_GET('busca') : '';
        $colunaBusca = $textoBusca !== '' ? ['name', 'email'] : null;
    }
    
    public function store()
    {   
        $foto = 'default-avatar.png';
    
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $nomeOriginal = $_FILES['foto']['name'];
        $foto = time() . '_' . $nomeOriginal;
        $diretorioDestino = __DIR__ . '/../../public/uploads/' . $foto;
        move_uploaded_file($_FILES['foto']['tmp_name'], $diretorioDestino);
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

    public function edit()
    {
        $parameters = [
            'nome' => $_POST['nome'],
            'email' => $_POST['email'],
            'senha'  => $_POST['senha'],

            // 'foto'  => $foto
        ];

        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $nomeOriginal = $_FILES['foto']['name'];
            $foto = time() . '_' . $nomeOriginal;
            $diretorioDestino = __DIR__ . '/../../public/uploads/' . $foto;
            move_uploaded_file($_FILES['foto']['tmp_name'], $diretorioDestino);
            
            $parameters['foto'] = $foto; 
        }

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