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

        $database = App::get('database');
        
        $limit = 5;

        $currentPage = isset($_GET['page']) ? (int)$_GET['page']:1;

        if($currentPage < 1){
            $currentPage = 1;
        }

        $offset = ($currentPage - 1) * $limit;
        $busca = $_GET['busca'] ?? '';

        $totalPosts = $database->countAll('tabela_posts');
        $totalPages = ceil($totalPosts/$limit);

        $posts = $database->paginate('tabela_posts', $limit, $offset, $busca);
        

        // $posts = App::get('database') -> selectAllPosts();

        // $totalPosts = App::get('database')->countAll('tabela_posts');


        return view('admin/tabelapost', [
            'posts' => $posts,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages

        ]);
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

    public function update()
    {
        $database = App::get('database');

        $id = isset($_POST['id_post']) ? (int)$_POST['id_post'] : null;

        if (!$id) {
            header('Location: /tabelapost');
            exit;
        }

        $post = $database->findById('tabela_posts', 'id_post', $id);

        $parameters = [
            'titulo' => $_POST['titulo'] ?? $post['titulo'],
            'descricao' => $_POST['descricao'] ?? $post['descricao'],
            'categoria' => $_POST['categoria'] ?? $post['categoria'],
        ];

        // tratar imagem somente se uma nova for enviada
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $nomeArquivo = uniqid() . '_' . basename($_FILES['imagem']['name']);
            $destino = __DIR__ . '/../../public/assets/posts/' . $nomeArquivo;
            move_uploaded_file($_FILES['imagem']['tmp_name'], $destino);

            // remover imagem antiga se existir
            if (!empty($post['imagem'])) {
                $oldPath = __DIR__ . '/../../public/assets/posts/' . $post['imagem'];
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }

            $parameters['imagem'] = $nomeArquivo;
        }

        $database->update('tabela_posts', 'id_post', $id, $parameters);

        header('Location: /tabelapost');
    }

    public function destroy()
    {
        $database = App::get('database');

        $id = null;
        if (isset($_POST['id_post'])) {
            $id = (int)$_POST['id_post'];
        } elseif (isset($_GET['id_post'])) {
            $id = (int)$_GET['id_post'];
        }

        if (!$id) {
            header('Location: /tabelapost');
            exit;
        }

        $post = $database->findById('tabela_posts', 'id_post', $id);

        // excluir imagem física
        if ($post && !empty($post['imagem'])) {
            $path = __DIR__ . '/../../public/assets/posts/' . $post['imagem'];
            if (file_exists($path)) {
                @unlink($path);
            }
        }

        // remover registro do banco
        $database->delete('tabela_posts', 'id_post', $id);

        header('Location: /tabelapost');
    }


    //Retorna os 5 ultimos posts para a landing page
    public function landingPage(){
        $database = App::get('database');
        $posts = $database->paginate('tabela_posts', 5, 0);

        return view('site/landing-page', [
            'posts' => $posts,
        ]);
    }

    public function postIndividual(){
        $database = App::get('database');

        $id = isset($_GET['id_post']) ? (int)$_GET['id_post'] : null;

        if(!$id){
            header('Location: /landing-page');
            exit;
        }

        $post = $database->findPost($id);

        if (!$post) {
            header('Location: /landing-page');
            exit;
        }

        $postsDoAutor = $database->getPostsByAutor($post['autor']);

        return view('site/Post-individual', [
            'post' => $post,
            'postsDoAutor' => $postsDoAutor,
        ]);

    }

    public function posts(){
        $database = App::get('database');
        $limit = 6;
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        if($currentPage < 1) {
            $currentPage = 1;
        }

        $offset = ($currentPage - 1) * $limit;

        $totalPosts = $database->countAll('tabela_posts');
        $totalPages = ceil($totalPosts/$limit);

        $posts = $database->paginate('tabela_posts', $limit, $offset);

        return view('site/lista-de-posts', [
            'posts' => $posts,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
        ]);
    }


}