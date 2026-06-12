<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tabela de Posts</title>

    <link rel="stylesheet" href="../../../public/css/tabelapost.css">
    <link rel="stylesheet" href="../../../public/css/modais.css">
    <link rel="stylesheet" href="../../../public/css/modais-posts.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body>


    <!-- Fundo Escuro -->
    <div class="filtro" id="filtro"></div>

    <div class="layout">

        <aside class="sidebar"></aside>

        <main class="conteudo">
            <!-- Sombreado para quando abrir os modais -->
            <div class="filtro" id="filtro"></div>
            <header class="topbar">

                <div class="titulo-area">

                    <i class="bi bi-card-checklist"></i>

                    <h1>Tabela de Posts</h1>

                </div>

                <div class="perfil">

                    
                    <div class="avatar">

                        <img src="../../../public/assets/fotousuario.jpg" alt="Foto do usuário" class="foto-perfil">

                    </div>

                    <button class="botao-admin">

                        Admin

                        <i class="bi bi-caret-down-fill"></i>

                    </button>

                </div>

            </header>


            <section class="secao-tabela">

                <div class="acoes-tabela">

                    <div class="botoes-esquerda">

                        <button onclick="abriModal('modalCriar')">

                            <i class="bi bi-plus-square"></i>

                            Adicionar

                        </button>

                        <button>

                            <i class="bi bi-calendar-event"></i>

                            Datas

                        </button>

                        <button>

                            <i class="bi bi-funnel"></i>

                            Categorias

                        </button>

                    </div>
                
                    <form class="caixa-pesquisa" action="/tabelapost" method="GET">

                        <input type="text" placeholder="Buscar posts" name="busca">

                        <i class="bi bi-search"></i>

                    </form>

                </div>

                <div class="tabelaResponsiva">
                    <table class="tabela-posts">
                        
                        <thead class="cabecalho-tabela">
                            <tr>
                                <th><span>ID</span></th>
                                <th><span>Título</span></th>
                                <th><span>Autor</span></th>
                                <th><span>Categoria</span></th>
                                <th><span>Data</span></th>
                                <th><span>Ações</span></th>
                            </tr>
                            
                        </thead>

                        <tbody>

                            <?php foreach($posts as $post): ?>
                                <tr class="linha-post">
                                    <td>
                                        <span><?= $post->id_post ?></span>
                                    </td>
                                    <td class="info-post">
                                        <img src="../../../public/assets/posts/<?= $post->imagem?>" alt="Post" name="titulo">
                                        <p><?= $post->titulo ?></p>
                                    </td>
                                    <td class="info-autor"> <!--Arrumar por conta da chave estrangeira-->
                                        <img src="../../../public/assets/usuarios/<?= $post->foto_autor?>" alt="Autor" name="autor">
                                        <p><?= $post->autor ?></p>
                                    </td>
                                    <td class="tag" name="categoria">
                                        <?= $post->categoria ?>
                                    </td>
                                    <td>
                                        <span><?= date('d/m/Y', strtotime($post->data)) ?></span>
                                    </td>
                                    <td class="acoes">
                                        <button onclick="abriModal('modalVisualizar-<?= $post->id_post?>')"> 
                                            <i class="bi bi-eye"></i>
                                        </button>

                                        <button onclick="abriModal('modalEditar-<?= $post->id_post?>')">
                                            <i class="bi bi-pencil"></i>
                                        </button>

                                        <button onclick="abriModal('modalExcluir-<?= $post->id_post?>')">
                                            <i class="bi bi-trash"></i>
                                        </button>

                                    </td>
                                </tr>

                                
                            <?php endforeach ?>

                        </tbody>
                    </table>
                    <!-- <div class="tabela-posts">

                        <div class="cabecalho-tabela">

                            <span>ID</span>
                            <span>Título</span>
                            <span>Autor</span>
                            <span>Categoria</span>
                            <span>Data</span>
                            <span>Ações</span>

                        </div>



                        <div class="linha-post">

                            <span>0123456789</span>

                            <div class="info-post">

                                <img src="../../../public/assets/portacopo.jpg" alt="Post">

                                <p>Porta Copo</p>

                            </div>

                            <div class="info-autor">

                                <img src="../../../public/assets/fotousuario.jpg" alt="Autor">

                                <p>Vasco da Gama</p>

                            </div>

                            <div class="tag">
                                Post
                            </div>

                            <span>25/04/2026</span>

                            <div class="acoes">

                                <button onclick="abriModal('modalVisualizar')">
                                    <i class="bi bi-eye"></i>
                                </button>

                                <button onclick="abriModal('modalEditar')">
                                    <i class="bi bi-pencil"></i>
                                </button>

                                <button onclick="abriModal('modalExcluir')">
                                    <i class="bi bi-trash"></i>
                                </button>

                            </div>

                        </div>


                        <div class="linha-post">

                            <span>8473628190</span>

                            <div class="info-post">

                                <img src="../../../public/assets/dory.jpg" alt="Post">

                                <p>Dory</p>

                            </div>

                            <div class="info-autor">

                                <img src="../../../public/assets/fotousuario.jpg" alt="Autor">

                                <p>Hadassa</p>

                            </div>

                            <div class="tag">
                                Tutorial
                            </div>

                            <span>02/05/2026</span>

                            <div class="acoes">

                                <button>
                                    <i class="bi bi-eye"></i>
                                </button>

                                <button>
                                    <i class="bi bi-pencil"></i>
                                </button>

                                <button>
                                    <i class="bi bi-trash"></i>
                                </button>

                            </div>

                        </div>


                        <div class="linha-post">

                            <span>9182736455</span>

                            <div class="info-post">

                                <img src="../../../public/assets/toucafrango.jpg" alt="Post">

                                <p>Touca de Frango</p>

                            </div>

                            <div class="info-autor">

                                <img src="../../../public/assets/fotousuario.jpg" alt="Autor">

                                <p>Maria Luiza</p>

                            </div>

                            <div class="tag">
                                Dicas
                            </div>

                            <span>10/05/2026</span>

                            <div class="acoes">

                                <button>
                                    <i class="bi bi-eye"></i>
                                </button>

                                <button>
                                    <i class="bi bi-pencil"></i>
                                </button>

                                <button>
                                    <i class="bi bi-trash"></i>
                                </button>

                            </div>

                        </div>


                        <div class="linha-post">

                            <span>6655443322</span>

                            <div class="info-post">

                                <img src="../../../public/assets/mascaracroche.jpg" alt="Post">

                                <p>Mascara com Rosa</p>

                            </div>

                            <div class="info-autor">

                                <img src="../../../public/assets/fotousuario.jpg" alt="Autor">

                                <p>Murilo</p>

                            </div>

                            <div class="tag">
                                Materiais
                            </div>

                            <span>15/05/2026</span>

                            <div class="acoes">

                                <button>
                                    <i class="bi bi-eye"></i>
                                </button>

                                <button>
                                    <i class="bi bi-pencil"></i>
                                </button>

                                <button>
                                    <i class="bi bi-trash"></i>
                                </button>

                            </div>

                        </div>
                    </div> -->

                    <?php if($totalPages >= 1):?>
                        <div class="paginacao-container">
                            <ul class="paginacao">
                                <li>
                                    <a href="?page=<?= max(1, $currentPage - 1) ?>" class="<?= $currentPage <= 1 ? 'disabled' : ''?>"><i class="bi bi-chevron-left"></i></a>
                                </li>

                                <?php
                                    $start = max(2, $currentPage - 1);
                                    $end = min($totalPages-1, $currentPage+1);
                                
                                ?>

                                <li>
                                    <a href="?page=1" class="<?= $currentPage == 1 ? 'active' : ''?>">1</a>
                                </li> 
                                
                                <?php if ($start > 3):?>
                                    <li><span class="dots">...</span>></li>
                                <?php endif; ?>

                                <?php for($i= $start; $i <=$end; $i++):?>
                                    <li>
                                        <a href="?page=<?= $i ?>" class="<?= $currentPage == $i ? 'active' : ''?>"> <?= $i ?></a>
                                    </li> 
                                <?php endfor; ?>

                                <?php if ($end < $totalPages - 1):?>
                                    <li><span class="dots">...</span>></li>
                                <?php endif; ?>

                                <li>
                                    <a href="?page=<?= $totalPages?>" class="<?= $currentPage == $totalPages ? 'active' : ''?>"><?= $totalPages?></a>
                                </li> 

                                <li>
                                    <a href="?page=<?= min($totalPages, $currentPage + 1) ?>" class="<?= $currentPage >= $totalPages ? 'disabled' : ''?>"><i class="bi bi-chevron-right"></i></a>
                                </li>

                            </ul>
                        </div>
                    <?php endif; ?>
                    <!-- <div class="paginacao">

                        <button>
                            <i class="bi bi-chevron-left"></i>
                        </button>

                        <button class="ativo">1</button>

                        <button>2</button>

                        <button>3</button>

                        <span>...</span>

                        <button>6</button>

                        <button>
                            <i class="bi bi-chevron-right"></i>
                        </button>

                    </div> -->

                    
                </div>

            </section>

        </main>

    </div>

    <!-- Modal Criar Post -->
    <form class="post-modalCriar" id="modalCriar" action="/tabelapost/create" method="POST" enctype="multipart/form-data">

        <div class="post-modal-header">
            <img src="../../../public/assets/Novelo_cortado.png" alt="">
            <p>Criar Post</p>
        </div>

        <div class="post-formContent">
            <!-- Upload Imagem -->
            <div class="upload">
                <label class="post-uploadImage" for="imagemPost">
                    <i class="bi bi-cloud-arrow-up-fill"></i>
                    <p>Arraste uma nova imagem ou <b>clique para fazer upload</b></p>
                </label>
                <input type="file" id="imagemPost" name="imagem" accept="image/*" hidden>
            </div>

            <!-- Título -->
            <div class="post-titulo">
                <label>Título do Post*</label>
                <input type="text" name="titulo" placeholder="Digite o título do post" required>
            </div>

            <!-- Descrição -->
            <div class="post-descricao">
                <label>Descrição*</label>
                <textarea type="text" name="descricao" placeholder="Digite a descrição" required></textarea>
            </div>

            <!-- Categorias -->
            <div class="post-categoria">
                <label>Categoria(s)*</label>
                <input type="text" name="categoria" placeholder="Adicione categorias (ex: tutoriais, roupas e etc)">
            </div>

            <div class="post-modalActions">
                <button class="post-btnCancel" type="button" onclick="fecharModal('modalCriar')">Cancelar</button>
                <button class="post-btnCreate" type="submit">Criar</button>
            </div>
        </div>

    </form>
    
    <?php foreach($posts as $post): ?>
        <!-- Modal Visualizar Post -->
        <div class="post-modalVisualizar" id="modalVisualizar-<?= $post->id_post ?>">
            <div class="post-modal-header">
                <img src="../../../public/assets/Novelo_cortado.png" alt="">
                <p>Visualizar Post</p>
            </div>

            <div class="post-modalContent">
                <!-- Imagem Post -->
                <div class="post-imagem">
                    <img src="../../../public/assets/posts/<?= $post->imagem ?>" alt="Imagem Post">
                </div>

                <!-- Título -->
                <div class="titulo">
                    <label>Título do Post</label>
                    <div class="input-titulo">
                        <p><?= $post->titulo ?></p>
                    </div>
                </div>

                <!-- Descrição -->
                <div class="descricao">
                    <label>Descrição</label>
                    <div class="input-descricao">
                        <p><?= $post->descricao ?></p>
                    </div>
                </div>

                <!-- Categorias -->
                <div class="categoria">
                    <label>Categoria(s)</label>
                    <div class="input-categoria">
                        <?= $post->categoria?>
                    </div>
                </div>

                <div class="autor">
                    <label>Autor</label>
                    <div class="input-autor">
                        <p><?= $post->nome_autor ?></p>
                    </div>
                </div>

                <div class="data">
                    <label>Data de Criação</label>
                    <div class="dataContent">
                        <div class="input-data">
                            <p><?= date('d/m/Y', strtotime($post->data)) ?></p>
                        </div>

                        <div class="modalActions">
                            <button class="btnClose" type="button" onclick="fecharModal('modalVisualizar-<?= $post->id_post ?>')">Fechar</button>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <!-- Modal Editar Post -->
        <form class="post-modalEditar" id="modalEditar-<?= $post->id_post ?>" method="POST" action="/tabelapost/update" enctype="multipart/form-data">

            <div class="post-modal-header">

                <img src="../../../public/assets/Novelo_cortado.png" alt="Logo">

                <p>Editar Post</p>

            </div>

            <div class="post-editContent">

                <!-- Imagem -->
                <label class="post-uploadImage" for="editarImagem-<?= $post->id_post ?>">

                    <img src="../../../public/assets/posts/<?= $post->imagem?>" alt="Imagem Post" class="post-imagemEditar">

                    <div class="post-overlayImagem">

                        <i class="bi bi-cloud-arrow-up-fill"></i>

                        <p>

                            Arraste uma nova imagem ou
                            <b>clique para fazer upload</b>

                        </p>

                    </div>

                </label>

                <input type="file" id="editarImagem-<?= $post->id_post ?>" name="imagem" hidden>
                <input type="hidden" name="id_post" value="<?= $post->id_post ?>">

                <!-- Titulo -->
                <div class="post-titulo">

                    <div class="post-tituloIcone">

                        <label>Título do Post</label>

                        <i class="bi bi-pencil-square"></i>

                    </div>

                    <input type="text" name="titulo" value="<?= $post->titulo ?>">

                </div>

                <!-- Descrição -->
                <div class="post-descricao">

                    <div class="post-tituloIcone">

                        <label>Descrição</label>

                        <i class="bi bi-pencil-square"></i>

                    </div>

                    <textarea name="descricao"><?= $post->descricao?></textarea>

                    <!-- <textarea name="descricao">Um porta-copo de crochê artesanal feito com carinho, unindo beleza, praticidade e um toque acolhedor para qualquer ambiente. Produzido com fios de qualidade e pontos delicados, ele protege superfícies contra manchas e calor, enquanto adiciona charme e personalidade à decoração. Perfeito para quem valoriza peças feitas à mão, esse acessório combina funcionalidade com o encanto único do crochê, trazendo um detalhe especial para sua mesa ou cantinho do café.</textarea> -->

                </div>

                <!-- Categorias -->
                <div class="post-categoria">

                    <div class="post-tituloIcone">

                        <label>Categoria(s)</label>

                        <i class="bi bi-pencil-square"></i>

                    </div>

                    <input type="text" name="categoria" value="<?= $post->categoria ?>">

                </div>

                <!-- Data -->
                <div class="post-data">

                    <label>Data de Criação</label>

                    <div class="post-input-data">

                        <?= date('d/m/Y', strtotime($post->data)) ?>

                    </div>

                </div>

                <!-- Botoes -->
                <div class="post-modalActions">

                    <button type="button" class="post-btnCancel" onclick="fecharModal('modalEditar-<?= $post->id_post ?>')">

                        Fechar

                    </button>

                    <button type="submit" class="post-btnCreate">

                        Confirmar

                    </button>

                </div>

            </div>

        </form>

        <!-- Modal Excluir Post -->
        <form class="modalVisualizar" id="modalExcluir-<?= $post->id_post ?>" action="/tabelapost/delete" method="POST">

            <div class="header">

                <img src="../../../public/assets/Novelo_cortado.png" alt="Logo">

                <p>Excluir Post</p>

            </div>

            <div class="modalContent">

                <input type="hidden" name="id_post" value="<?= $post->id_post ?>">

                <!-- Texto -->
                <div class="textoExcluir">

                    <h2>
                        Tem certeza que deseja
                        excluir este post?
                    </h2>

                </div>

                <!-- Imagem -->
                <img src="../../../public/assets/posts/<?= $post->imagem ?>" alt="Post" class="imagemExcluir">

                <!-- Titulo -->
                <div class="tituloExcluir">

                    <label>Título do Post :</label>

                    <div class="inputExcluir">

                        <?= $post->titulo?>

                    </div>

                </div>

                <!-- Alerta -->
                <div class="alertaExcluir">

                    <i class="bi bi-exclamation-triangle"></i>

                    <p>Essa ação não poderá ser desfeita.</p>

                </div>

                <!-- Botoes -->
                <div class="modalActions">

                    <button type="button" class="btnCancel" onclick="fecharModal('modalExcluir-<?= $post->id_post ?>')">

                        Cancelar

                    </button>

                    <button type="submit" class="btnDelete">

                        Excluir

                    </button>

                </div>

            </div>

        </form>

    <?php endforeach ?>

    <script src="../../../public/js/modais.js"></script>

</body>

</html>