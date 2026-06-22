<?php

namespace App\Controllers;

use App\Core\App;
use Exception;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class UsuariosController
{

    public function index()
    {
        if (!isset($_SESSION['id']) || $_SESSION['tipo'] !== 'admin') {
           header('Location: /login');
           exit;
        }

    $busca = $_GET['busca'] ?? '';
    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $perPage = 5;
    $offset = ($currentPage - 1) * $perPage;
    $sufixoFiltros = $busca ? '&busca=' . urlencode($busca) : '';
    $totalUsuarios = App::get('database')->countUsuarios($busca);

    $totalPages = ceil($totalUsuarios / $perPage);
    $currentPage = max(1, min($currentPage, $totalPages));

    $usuarios = App::get('database')->paginateUsuarios($perPage, $offset, $busca);
    $usuarioLogado = App::get('database')->findById('tabela_usuarios', 'id', $_SESSION['id']);

    return view('admin/crudUsuarios', compact('usuarios', 'currentPage', 'totalPages','sufixoFiltros', 'usuarioLogado'));

    }
    
    public function store()
    {   
        if (!isset($_SESSION['id']) || $_SESSION['tipo'] !== 'admin') {
            header('Location: /login');
            exit;
        }

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
        if (!isset($_SESSION['id']) || $_SESSION['tipo'] !== 'admin') {
            header('Location: /login');
            exit;
        }

        $parameters = [
            'nome' => $_POST['nome'],
            'email' => $_POST['email'],
            'senha'  => $_POST['senha'],
        ];

        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $nomeOriginal = $_FILES['foto']['name'];
            $foto = time() . '_' . $nomeOriginal;
            $diretorioDestino = __DIR__ . '/../../public/uploads/' . $foto;
            move_uploaded_file($_FILES['foto']['tmp_name'], $diretorioDestino);
            
            $parameters['foto'] = $foto; 
        }

        $id = $_POST['id'];

        App::get('database')->update('tabela_usuarios', 'id', $id, $parameters);

        $redirect = $_POST['redirect'] ?? '/crudUsuarios';
        
        header("Location: {$redirect}");
        exit;
    }

    public function delete()
    {
        if (!isset($_SESSION['id']) || $_SESSION['tipo'] !== 'admin') {
            header('Location: /login');
            exit;
        }

        $id = $_POST['id'];

        App::get('database')->delete('tabela_usuarios', $id);

        header('Location: /crudUsuarios');
    }
}