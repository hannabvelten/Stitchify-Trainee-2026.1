

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stitchify - Meu Perfil</title>

    <link rel="stylesheet" href="../../../public/css/perfil-usuario.css">
    <link rel="stylesheet" href="../../../public/css/modais.css">
    <link rel="stylesheet" href="../../../public/css/modais-posts.css">
    <link rel="stylesheet" href="../../../public/css/edituser.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body>

    <!-- Fundo escuro dos modais -->
    <div class="filtro" id="filtro"></div>

    <div class="container">

        <div class="pagina-perfil">

            <!-- CABEÇALHO -->
            <section class="cabecalho-perfil">

                <h1 class="titulo-perfil">
                    Meu Perfil
                </h1>

            </section>

            <!-- Boas Vindas -->
            <section class="boas-vindas">

                <p>
                    Gerencie suas informações, veja seus posts e edite o que precisar.
                </p>

            </section>

            <!-- Perfil -->
            <section class="perfil">

                <div class="card-perfil">

                    <div class="dados-usuario">
  <?php if (!empty($usuario->foto)): ?>
                  <img src="../../../public/uploads/<?= htmlspecialchars($usuario->foto) ?>" alt="Foto de <?= htmlspecialchars($usuario->nome) ?>"         
class="foto-perfil" />
                  <?php else: ?>
                  <img src="../../../public/assets/PersonCircle.svg" alt="Sem foto"  />
                  <?php endif; ?>

                        <div class="informacoes-usuario">

                            <div class="nome-email">

                                <h2><?= $usuario->nome ?></h2>

                                <p><?= $usuario->email ?></p>

                            </div>


                        </div>

                    </div>

                    <button class="botao-editar" type="button" onclick="abrirModalEditarPerfil()">

                        <i class="bi bi-pencil"></i>

                        Editar Perfil

                    </button>
                   <?php if ($isAdmin): ?>
                    <button class="btn-dashboardd" onclick="window.location.href='/admin/dashboard'">
                     Ir para Dashboard
                     </button>
                    <?php endif; ?>



                </div>

            </section>

            <!-- CABEÇALHO DOS POSTS -->
            <section class="secao-posts">

                <div class="cabecalho-posts">

                    <h2 class="titulo-posts">
                        Meus Posts
                    </h2>

                    <button class="botao-criar-post" type="button" onclick="abriModal('modalCriar')">

                        <i class="bi bi-plus-lg"></i>

                        Criar Post

                    </button>

                </div>

            </section>

            <!-- LISTA DE POSTS -->
            <div class="lista-posts">

                <?php if(empty($posts)): ?>

                    <p class="mensagem-sem-posts">
                        Você ainda não criou nenhum post.
                    </p>

                <?php else: ?>

                    <?php foreach($posts as $post): ?>

                        <article class="card-post">

                            <img
                                src="../../../public/assets/posts/<?= $post->imagem ?>"
                                alt="Imagem do Post"
                                class="imagem-post"
                            >

                            <div class="informacoes-post">

                                <div class="titulo-data-post">

                                    <h3 class="titulo-post">
                                        <?= $post->titulo ?>
                                    </h3>

                                    <div class="data-post">

                                        <i class="bi bi-calendar3"></i>

                                        <span><?= date('d/m/Y', strtotime($post->data)) ?></span>

                                    </div>

                                </div>

                                <p class="descricao-post">
                                    <?= $post->descricao ?>
                                </p>

                                <div class="categorias-post">

                                    <span class="categoria-post">
                                        <?= $post->categoria ?>
                                    </span>

                                </div>

                            </div>

                            <div class="acoes-post">

                                <button class="botao-visualizar" type="button" onclick="abriModal('modalVisualizar-<?= $post->id_post ?>')">

                                    <i class="bi bi-eye"></i>

                                    Visualizar

                                </button>

                                <button class="botao-editar-post" type="button" onclick="abriModal('modalEditar-<?= $post->id_post ?>')">

                                    <i class="bi bi-pencil"></i>

                                    Editar

                                </button>

                                <button class="botao-deletar-post" type="button" onclick="abriModal('modalExcluir-<?= $post->id_post ?>')">

                                    <i class="bi bi-trash"></i>

                                    Deletar

                                </button>

                            </div>

                        </article>

                    <?php endforeach; ?>

                <?php endif; ?>

            </div>

        </div>

    </div>

    <!-- Modal Criar Post -->
    <form class="post-modalCriar" id="modalCriar" action="/tabelapost/create" method="POST" enctype="multipart/form-data">

        <input type="hidden" name="redirect" value="/perfil-usuario">

        <div class="post-modal-header">

            <img src="../../../public/assets/Novelo_cortado.png" alt="Logo">

            <p>Criar Post</p>

        </div>

        <div class="post-formContent">

            <!-- Upload Imagem -->
            <div class="upload">

                <label class="post-uploadImage" for="imagemPost">

                    <i class="bi bi-cloud-arrow-up-fill"></i>

                    <p>
                        Arraste uma nova imagem ou <b>clique para fazer upload</b>
                    </p>

                </label>

                <input type="file" id="imagemPost" name="imagem" accept="image/*" hidden required>

            </div>

            <!-- Título -->
            <div class="post-titulo">

                <label>Título do Post*</label>

                <input type="text" name="titulo" placeholder="Digite o título do post" required>

            </div>

            <!-- Descrição -->
            <div class="post-descricao">

                <label>Descrição*</label>

                <textarea name="descricao" placeholder="Digite a descrição" required></textarea>

            </div>

            <!-- Categorias -->
            <div class="post-categoria">

                <label>Categoria(s)*</label>

                <input type="text" name="categoria" placeholder="Adicione categorias (ex: tutoriais, roupas e etc)" required>

            </div>

            <div class="post-modalActions">

                <button class="post-btnCancel" type="button" onclick="fecharModal('modalCriar')">
                    Cancelar
                </button>

                <button class="post-btnCreate" type="submit">
                    Criar
                </button>

            </div>

        </div>

    </form>

    <?php if(!empty($posts)): ?>

        <?php foreach($posts as $post): ?>

            <!-- Modal Visualizar Post -->
            <div class="post-modalVisualizar" id="modalVisualizar-<?= $post->id_post ?>">

                <div class="post-modal-header">

                    <img src="../../../public/assets/Novelo_cortado.png" alt="Logo">

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

                    <!-- Categoria -->
                    <div class="categoria">

                        <label>Categoria(s)</label>

                        <div class="input-categoria">

                            <?= $post->categoria ?>

                        </div>

                    </div>

                    <!-- Autor -->
                    <div class="autor">

                        <label>Autor</label>

                        <div class="input-autor">

                            <p><?= $usuario->nome ?></p>

                        </div>

                    </div>

                    <!-- Data -->
                    <div class="data">

                        <label>Data de Criação</label>

                        <div class="dataContent">

                            <div class="input-data">

                                <p><?= date('d/m/Y', strtotime($post->data)) ?></p>

                            </div>

                            <div class="modalActions">

                                <button class="btnClose" type="button" onclick="fecharModal('modalVisualizar-<?= $post->id_post ?>')">
                                    Fechar
                                </button>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- Modal Editar Post -->
            <form class="post-modalEditar" id="modalEditar-<?= $post->id_post ?>" method="POST" action="/tabelapost/update" enctype="multipart/form-data">

                <input type="hidden" name="redirect" value="/perfil-usuario">

                <div class="post-modal-header">

                    <img src="../../../public/assets/Novelo_cortado.png" alt="Logo">

                    <p>Editar Post</p>

                </div>

                <div class="post-editContent">

                    <!-- Imagem -->
                    <label class="post-uploadImage" for="editarImagem-<?= $post->id_post ?>">

                        <img src="../../../public/assets/posts/<?= $post->imagem ?>" alt="Imagem Post" class="post-imagemEditar">

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

                    <!-- Título -->
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

                        <textarea name="descricao"><?= $post->descricao ?></textarea>

                    </div>

                    <!-- Categoria -->
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

                    <!-- Botões -->
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

                <input type="hidden" name="redirect" value="/perfil-usuario">

                <div class="post-modal-header">

                    <img src="../../../public/assets/Novelo_cortado.png" alt="Logo">

                    <p>Excluir Post</p>

                </div>

                <div class="post-modalContent">

                    <input type="hidden" name="id_post" value="<?= $post->id_post ?>">

                    <!-- Texto -->
                    <div class="post-textoExcluir">

                        <h2>
                            Tem certeza que deseja<br>
                            excluir este post?
                        </h2>

                    </div>

                    <!-- Imagem -->
                    <img src="../../../public/assets/posts/<?= $post->imagem ?>" alt="Post" class="post-imagemExcluir">

                    <!-- Título -->
                    <div class="post-tituloExcluir">

                        <label>Título do Post :</label>

                        <div class="post-inputExcluir">

                            <?= $post->titulo ?>

                        </div>

                    </div>

                    <!-- Alerta -->
                    <div class="post-alertaExcluir">

                        <i class="bi bi-exclamation-triangle"></i>

                        <p>Essa ação não poderá ser desfeita.</p>

                    </div>

                    <!-- Botões -->
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

        <?php endforeach; ?>

    <?php endif; ?>

    <div class="fade-edit hide" id="fade-edit"></div>

    <div class="modal-editar hide" id="modal-editar-perfil">

        <form class="modaledit" id="modaledit" action="/crudUsuarios/edit" method="POST" enctype="multipart/form-data">

            <input type="hidden" name="id" value="<?= $usuario->id ?>">
            <input type="hidden" name="redirect" value="/perfil-usuario">

            <div class="topo-edit">

                <img src="../../../public/assets/Novelo_cortado.png" alt="Logo">

                <p>Editar Perfil</p>

            </div>

            <div class="edit-form">

                <div class="edit-nome">

                    <label>Nome Completo:</label>

                    <input
                        type="text"
                        name="nome"
                        value="<?= $usuario->nome ?>"
                        placeholder="Nome completo"
                        required
                    >

                </div>

                <div class="edit-email">

                    <label>Novo Email:</label>

                    <input
                        type="email"
                        name="email"
                        value="<?= $usuario->email ?>"
                        placeholder="Email atual"
                        required
                    >

                </div>

                <div class="edit-senha">

                    <label>Nova Senha:</label>

                    <input
                        type="password"
                        name="senha"
                        placeholder="Digite a nova senha"
                        required
                    >

                </div>

                <div class="edit-foto">

                    <p>Foto do Usuário</p>

                    <div class="foto-container">

                        <button type="button" class="foto-usuario" id="btnFotoEdit">

                            <img
                                src="../../../public/assets/adicioanar-foto.svg"
                                alt="Adicionar foto"
                                class="nova-foto"
                                id="fotoIconEdit"
                            >

                            <img
                                src=""
                                alt="Preview"
                                id="fotoPreviewEdit"
                                style="display: none;"
                            >

                        </button>

                        <input type="file" id="inputFotoEdit" name="foto" hidden>

                    </div>

                </div>

                <div class="botoes-edit">

                    <button class="cancel" type="button" onclick="fecharModalEditarPerfil()">
                        Cancelar
                    </button>

                    <button class="confirm" type="submit">
                        Confirmar alterações
                    </button>

                </div>

            </div>

        </form>

    </div>

    <script src="../../../public/js/modais.js"></script>
    <script>
        function abrirModalEditarPerfil() {
            document.getElementById('modal-editar-perfil').classList.remove('hide');
            document.getElementById('fade-edit').classList.remove('hide');
        }

        function fecharModalEditarPerfil() {
            document.getElementById('modal-editar-perfil').classList.add('hide');
            document.getElementById('fade-edit').classList.add('hide');
        }

        const btnFotoEdit = document.getElementById('btnFotoEdit');
        const inputFotoEdit = document.getElementById('inputFotoEdit');
        const fotoIconEdit = document.getElementById('fotoIconEdit');
        const fotoPreviewEdit = document.getElementById('fotoPreviewEdit');

        if (btnFotoEdit && inputFotoEdit) {
            btnFotoEdit.addEventListener('click', function () {
                inputFotoEdit.click();
            });
        }

        if (inputFotoEdit) {
            inputFotoEdit.addEventListener('change', function () {
                const arquivo = this.files[0];

                if (arquivo) {
                    const leitor = new FileReader();

                    leitor.onload = function (evento) {
                        fotoPreviewEdit.src = evento.target.result;
                        fotoPreviewEdit.style.display = 'block';
                        fotoIconEdit.style.display = 'none';
                    };

                    leitor.readAsDataURL(arquivo);
                }
            });
        }
    </script>

</body>

</html>