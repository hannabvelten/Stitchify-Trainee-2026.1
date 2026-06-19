<?php

namespace App\Controllers;

use App\Core\App;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class DashboardController
{
    public function index()
    {
        if (!isset($_SESSION['id']) || $_SESSION['tipo'] !== 'admin') {
            header('Location: /login');
            exit;
        }

        $database = App::get('database');

        $totalUsuarios = $database->countAll('tabela_usuarios');
        $totalPublicacoes = $database->countAll('tabela_posts');

        $admin = $database->findById('tabela_usuarios', 'id', $_SESSION['id']);

        return view('admin/dashboard', [
            'totalUsuarios' => $totalUsuarios,
            'totalPublicacoes' => $totalPublicacoes,
            'admin' => $admin
        ]);
    }
}