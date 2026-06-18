<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Stitchify</title>

    <link rel="stylesheet" href="../../../public/css/Post-individual.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=arrow_back_ios,arrow_forward_ios" />
    <link 
    rel="stylesheet" 
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body>
    <div class="navbar">
        <?php require("app/views/site/navbar.php")?>
    </div>
    
    <div class="content">

    
        <div class="container">

            <h2 class="titulo-pagina">Publicações</h2>

            <div class="conteudo">

                <!-- POST -->

                <section class="post">

                    <h1><?= htmlspecialchars($post['titulo']) ?></h1>

                    <div class="info-post">

                        <span>

                            <i class="bi bi-person"></i>

                            <?= htmlspecialchars($post['nome_autor']) ?>

                        </span>

                        <span>

                            <i class="bi bi-calendar"></i>

                            <?= date('d \d\e F \d\e Y', strtotime($post['data'])) ?>

                        </span>

                        <span>

                            <i class="bi bi-geo-alt"></i>

                            Juiz de Fora, Brasil

                        </span>

                    </div>

                    <img 
                        src="../../../public/assets/posts/<?= htmlspecialchars($post['imagem']) ?>" 
                        alt="<?= htmlspecialchars($post['titulo']) ?>"
                        class="imagem-post">

                    <p>

                        <?= htmlspecialchars($post['descricao']) ?>

                    </p>

                </section>


                <!-- SIDEBAR -->

                <aside class="sidebar">

                    <!-- AUTOR -->

                    <div class="autor-card">

                        <h2>Sobre o Autor</h2>

                        <img 
                        src="../../../public/assets/usuarios/<?= htmlspecialchars($post['foto_autor']) ?>" 
                        alt="Foto do autor"
                        class="foto-perfil">

                        <button onclick="abrirModal('modalAutor')">

                            Ver Perfil

                        </button>

                    </div>


                    <!-- CATEGORIAS -->

                    <div class="categorias">

                        <h2>Categoria</h2>

                        <ul>

                            <li>Dicas</li>

                            <li>Materiais</li>

                            <li>Tutoriais</li>

                            <li>Roupas</li>

                        </ul>

                    </div>

                </aside>

            </div>

        </div>

        <!-- Modal Autor -->
        <div class="fundo-modal" id="fundoModal"></div>

    
        <div class="modal-autor" id="modalAutor">


            <!-- TOPO -->

            <div class="topo-modal-autor">

                <img 
                src="../../../public/assets/usuarios/<?= htmlspecialchars($post['foto_autor']) ?>" 
                alt="Foto do autor"
                class="foto-modal-autor">

                <div class="informacoes-autor">

                    <h2><?= htmlspecialchars($post['nome_autor']) ?></h2>

                    <span>

                        <i class="bi bi-geo-alt"></i>

                        Cabo Frio, Brasil

                    </span>

                </div>

            </div>

            
            <div class="conteudo-modal-autor">

                <div class="titulo-posts">
                    <img 
                        src="../../../public/assets/Novelologo3.png" 
                        alt="novelo logo"
                    >

                    <h2>Posts do Autor</h2>
                </div>

                <div class="cards-blog-autor">
                <!-- <div class="lista-posts-autor"> -->
                    <span class="material-symbols-outlined" id="seta-esquerda">arrow_back_ios</span>

                    <div class="slider-conteudo-autor">
                        <?php foreach ($postsDoAutor as $postAutor):?>
                            <div class="card-post-autor">
                                <img 
                                src="../../../public/assets/posts/<?= htmlspecialchars($postAutor['imagem']) ?>" 
                                alt="<?= htmlspecialchars($postAutor['titulo']) ?>">

                                <div class="informacoes-post-autor">

                                    <h3><?= htmlspecialchars($postAutor['titulo']) ?></h3>

                                    <a href="/Post-individual?id_post=<?= $postAutor['id_post'] ?>" class="botao">Ver mais</a>

                                </div>
                            </div>
                                
                                
                        <?php endforeach;?>
                    </div>
                    
                    <span class="material-symbols-outlined" id="seta-direita">arrow_forward_ios</span>

                </div>

            </div>


            <div class="acoes-modal-autor">

                <button onclick="fecharModal('modalAutor')">

                    Fechar

                </button>

            </div>

        </div>
    </div>

    <div class="footer">
        <?php require("app/views/site/footer.php")?>
    </div>
    
    <script src="../../../public/js/modal.js"></script>

</body>

</html>