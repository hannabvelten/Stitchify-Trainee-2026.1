<?php

namespace App\Controllers;

use App\Core\App;
use Exception;

class PostsController
{

    public function index()
    {
        $posts = App::get('database') -> selectAll('tabela_posts');
        return view('admin/tabelapost', $posts);
    }
}