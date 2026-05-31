<?php
namespace App\Controllers;

use App\Core\App;
use Exception;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class PostsController
{

    public function index()
    {
        $posts = App::get('database') -> selectAllPosts();
        return view('admin/tabelapost', compact('posts'));
    }

    public function store()
    {
        // Como estamos salvando imagens precisamos fazer essa parte
        // Basicamente, eu criei uma pasta dentro de assets(posts) que vai ter
        // as imagens dos posts, e vamos salvar apenas os nomes delas no BD
        // assim quando acessarmos os posts e etc vamos pegar elas.

        $nomeArquivo = uniqid() . '_' . basename($_FILES['imagem']['name']);
        $destino = __DIR__ . '/../../public/assets/posts/' . $nomeArquivo;
        move_uploaded_file($_FILES['imagem']['tmp_name'], $destino);

        // Outra coisa que precisamos fazer é o autor, vamos utilizar o id do usuario
        // que estiver logado, para isso utilizamos sessoes. As sessoes basicamente sao
        // os "dados" salvos de cada usuario, aí com essas sessoes conseguimos verificar
        // se ele é admin ou nao, se ele pode modificar outros posts e etc. Ai precisamos
        // colocar no topo de cada pagina session_start();

        $parameters = [
            'titulo' => $_POST['titulo'],
            'descricao' => $_POST['descricao'],
            'imagem' => $nomeArquivo,
            'autor' => 1, //Teste - $_SESSION['id_usuario'],
            'categoria' => $_POST['categoria'],
        ];

        App::get('database') -> insert('tabela_posts', $parameters);
        
        header('Location: /tabelapost');
    }
}