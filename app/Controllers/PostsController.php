<?php

namespace App\Controllers;

use App\Core\App;
use Exception;

class PostsController
{

    public function index()
    {
        $posts = App::get('database') -> selectAll('tabela_posts');
        return view('admin/tabelapost', compact('posts'));
    }

    public function store()
    {
        $parameters = [
            'titulo' => $_POST['titulo'],
            'descricao' => $_POST['descricao'],
            'imagem' => $_POST['imagem'],
            'autor' => $_POST['autor'],
            'categoria' => $_POST['categoria'],
        ];

        App::get('database') -> insert('tabela_posts', $parameters);
        
        header('Location: /tabelapost');
    }
}