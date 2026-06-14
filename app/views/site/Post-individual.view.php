<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Stitchify</title>

    <link rel="stylesheet" href="../../../public/css/Post-individual.css">

    <link 
    rel="stylesheet" 
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body>

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

                    <h2>Categorias</h2>

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

            
            <div class="lista-posts-autor">

                <?php foreach ($postsDoAutor as $postAutor):?>
                    <a href="/Post-individual?id_post=<?= $postAutor['id_post'] ?>" class="card-post-autor">
                        <img 
                        src="../../../public/assets/posts/<?= htmlspecialchars($postAutor['imagem']) ?>" 
                        alt="<?= htmlspecialchars($postAutor['titulo']) ?>">

                        <div class="informacoes-post-autor">

                            <h3><?= htmlspecialchars($postAutor['titulo']) ?></h3>

                            <span class="categoria-post">

                                <?= htmlspecialchars($postAutor['categoria']) ?>

                            </span>

                            <p>

                                <i class="bi bi-calendar3"></i>

                                <?= date('d \d\e F \d\e Y', strtotime($post['data'])) ?>

                            </p>

                        </div>
                        
                    </a>
                <?php endforeach;?>
                
                <!-- <div class="card-post-autor">

                    <img 
                    src="../../../public/assets/mascaracroche.jpg" 
                    alt="Máscara">

                    <div class="informacoes-post-autor">

                        <h3>Máscara Flor</h3>

                        <span class="categoria-post">

                            Utilidades

                        </span>

                        <p>

                            <i class="bi bi-calendar3"></i>

                            23 de Jun, 2026

                        </p>

                    </div>

                </div>
                

                <div class="card-post-autor">

                    <img 
                    src="../../../public/assets/toucafrango.jpg" 
                    alt="Touca">

                    <div class="informacoes-post-autor">

                        <h3>Touca Frango</h3>

                        <span class="categoria-post">

                            Roupas

                        </span>

                        <p>

                            <i class="bi bi-calendar3"></i>

                            24 de Jul, 2026

                        </p>

                    </div>

                </div>
              

                <div class="card-post-autor">

                    <img 
                    src="../../../public/assets/porta-copo.jpg" 
                    alt="Porta Copo">

                    <div class="informacoes-post-autor">

                        <h3>Porta Copo</h3>

                        <span class="categoria-post">

                            Materiais

                        </span>

                        <p>

                            <i class="bi bi-calendar3"></i>

                            25 de Ago, 2026

                        </p>

                    </div>

                </div> -->

            </div>

        </div>

      

        <div class="acoes-modal-autor">

            <button onclick="fecharModal('modalAutor')">

                Fechar

            </button>

        </div>

    </div>

    
    <script src="../../../public/js/modal.js"></script>

</body>

</html>