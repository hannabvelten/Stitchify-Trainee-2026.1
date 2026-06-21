<!DOCTYPE html>
<html lang="pt-BR">

<?php
$filtrosPaginacao = array_filter([
    'busca' => $busca ?? '',
    'categoria' => $categoria ?? '',
    'data_inicio' => $dataInicio ?? '',
    'data_fim' => $dataFim ?? '',
], function ($valor) {
    return $valor !== '' && $valor !== null;
});

$queryFiltros = http_build_query($filtrosPaginacao);
$sufixoFiltros = $queryFiltros !== '' ? '&' . $queryFiltros : '';
?>

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

        <?php require("app/views/admin/sidebar.php")?>

        <main class="conteudo">
            <!-- Sombreado para quando abrir os modais -->
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

                    </button>

                </div>

            </header>


            <section class="secao-tabela">

                <div class="acoes-tabela">

                    <form class="filtros-posts" action="/tabelapost" method="GET">

                        <button type="button" class="botao-adicionar" onclick="abriModal('modalCriar')">

                            <i class="bi bi-plus-square"></i>

                            Adicionar

                        </button>

                        <input class="campo-filtro" type="date" name="data_inicio" value="<?= htmlspecialchars($dataInicio ?? '') ?>" placeholder="Data inicial">

                        <input class="campo-filtro" type="date" name="data_fim" value="<?= htmlspecialchars($dataFim ?? '') ?>" placeholder="Data final">

                        <input class="campo-filtro" type="text" name="categoria" list="listaCategorias" value="<?= htmlspecialchars($categoria ?? '') ?>" placeholder="Categoria">

                        <datalist id="listaCategorias">
                            <?php foreach ($categorias as $categoriaItem): ?>
                                <?php if (!empty($categoriaItem->categoria)): ?>
                                    <option value="<?= htmlspecialchars($categoriaItem->categoria) ?>"></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </datalist>

                        <input class="campo-filtro campo-busca" type="text" name="busca" value="<?= htmlspecialchars($busca ?? '') ?>" placeholder="Buscar posts">

                        <button class="botao-buscar" type="submit" aria-label="Buscar">
                            <i class="bi bi-search"></i>
                        </button>

                        <a class="botao-limpar" href="/tabelapost">Limpar filtros</a>

                    </form>

                </div>

                <div class="tabelaResponsiva">
                    <table class="tabela-posts">
                        
                        <thead class="cabecalho-tabela">
                            <tr>
                                <th>ID</th>
                                <th>Título</th>
                                <th class="autor">Autor</th>
                                <th>Categoria</th>
                                <th>Data</th>
                                <th>Ações</th>
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
                                        <p><?= $post->nome_autor?></p>
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

                    
            </section>
            <?php if($totalPages > 1):?>
                <div class="paginacao-container">
                    <ul class="paginacao">
                        <li>
                            <a href="?page=<?= max(1, $currentPage - 1) ?><?= $sufixoFiltros ?>" class="<?= $currentPage <= 1 ? 'disabled' : ''?>"><i class="bi bi-chevron-left"></i></a>
                        </li>

                        <?php
                            $start = max(2, $currentPage - 1);
                            $end = min($totalPages-1, $currentPage+1);
                                
                        ?>

                        <li>
                            <a href="?page=1<?= $sufixoFiltros ?>" class="<?= $currentPage == 1 ? 'active' : ''?>">1</a>
                        </li> 
                                
                        <?php if ($start > 2):?>
                            <li><span class="dots">...</span>></li>
                        <?php endif; ?>

                        <?php for($i= $start; $i <=$end; $i++):?>
                            <li>
                                <a href="?page=<?= $i ?><?= $sufixoFiltros ?>" class="<?= $currentPage == $i ? 'active' : ''?>"> <?= $i ?></a>
                            </li> 
                        <?php endfor; ?>

                        <?php if ($end < $totalPages - 1):?>
                            <li><span class="dots">...</span>></li>
                        <?php endif; ?>

                        <li>
                            <a href="?page=<?= $totalPages?><?= $sufixoFiltros ?>" class="<?= $currentPage == $totalPages ? 'active' : ''?>"><?= $totalPages?></a>
                        </li> 

                        <li>
                            <a href="?page=<?= min($totalPages, $currentPage + 1) ?><?= $sufixoFiltros ?>" class="<?= $currentPage >= $totalPages ? 'disabled' : ''?>"><i class="bi bi-chevron-right"></i></a>
                        </li>

                    </ul>
                </div>
            <?php endif; ?>
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
        <form class="post-modalExcluir" id="modalExcluir-<?= $post->id_post ?>" action="/tabelapost/delete" method="POST">

            <div class="post-modal-header">

                <img src="../../../public/assets/Novelo_cortado.png" alt="Logo">

                <p>Excluir Post</p>

            </div>

            <div class="post-modalContent">

                <input type="hidden" name="id_post" value="<?= $post->id_post ?>">

                <!-- Texto -->
                <div class="post-textoExcluir">

                    <h2>
                        Tem certeza que deseja
                        excluir este post?
                    </h2>

                </div>

                <!-- Imagem -->
                <img src="../../../public/assets/posts/<?= $post->imagem ?>" alt="Post" class="post-imagemExcluir">

                <!-- Titulo -->
                <div class="post-tituloExcluir">

                    <label>Título do Post :</label>

                    <div class="post-inputExcluir">

                        <?= $post->titulo?>

                    </div>

                </div>

                <!-- Alerta -->
                <div class="post-alertaExcluir">

                    <i class="bi bi-exclamation-triangle"></i>

                    <p>Essa ação não poderá ser desfeita.</p>

                </div>

                <!-- Botoes -->
                <div class="post-modalActions">

                    <button type="button" class="post-btnCancel" onclick="fecharModal('modalExcluir-<?= $post->id_post ?>')">

                        Cancelar

                    </button>

                    <button type="submit" class="post-btnDelete">

                        Excluir

                    </button>

                </div>

            </div>

        </form>

    <?php endforeach ?>

    <script src="../../../public/js/modais.js"></script>

</body>

</html>