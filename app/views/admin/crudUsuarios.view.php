<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tabela de Usuários</title>
    <link rel="stylesheet" href="../../../public/css/pagusuario.css" />
    <link rel="stylesheet" href="../../../public/css/criauser.css" />
    <link rel="stylesheet" href="../../../public/css/visualizacao.css" />
    <link rel="stylesheet" href="../../../public/css/edituser.css" />
    <link rel="stylesheet" href="../../../public/css/deleteuser.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  </head>

  <body>
    <main>
      <?php require("app/views/admin/sidebar.php")?>
      <div class="paginausers">
        <div class="topo">
          <div class="usuarios">
            <img src="../../../public/assets/iconeuser.svg" alt="iconeuser" class="iconuser" />
            <h1>Tabela de usuários</h1>
          </div>
          <div class="box-perfiladm">
            <div class="admin">
              <div class="avatar">
                <img src="../../../public/uploads/<?= htmlspecialchars($usuarioLogado['foto']) ?>" alt="iconeperfil" class="foto-perfil"/>
              </div>
                
              <div class="textoadmin">
                <p><?= htmlspecialchars($usuarioLogado['nome']) ?></p>
              </div>
              
            </div>
            
          </div>
        </div>
        <div class="secao-tabela">
          <div class="box-criauser">

            <button class="criar-usuario">
              <i class="bi bi-plus-square"></i>
              Criar Usuário
            </button>

            <form class="caixa-pesquisa" action="/crudUsuarios" method="GET">
              <input
                type="text"
                placeholder="Busca por nome ou email"
                class="busca-user" name="busca"
              />
              <i class="bi bi-search"></i>
            </form>
          </div>

          <div class="box-users">
            <table class="cabecalho">
              <thead>
                <tr>
                  <th class="user">Usuário</th>
                  <th class="email">Email</th>
                  <th class="tipo">Tipo</th>
                  <th class="iduser">ID</th>
                  <th class="acoesu">Ações</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($usuarios as $usuario): ?>
                <tr>
                  <td class="nomec">
                    <?php if (!empty($usuario->foto)): ?>
                    <img src="../../../public/uploads/<?= htmlspecialchars($usuario->foto) ?>" alt="Foto de <?= htmlspecialchars($usuario->nome) ?>" class="foto-tabela-user" />
                    <?php else: ?>
                    <img src="../../../public/assets/PersonCircle.svg" alt="Sem foto"  />
                    <?php endif; ?><?= htmlspecialchars($usuario->nome)?>
                  </td>
                  <td class="emailc"><?= htmlspecialchars($usuario->email)?></td>
                  <td class="tipoc">
                    <span class="adm"> <?= htmlspecialchars($usuario->tipo)?></span>
                  </td>
                  <td class="iduser">
                    <p><?= htmlspecialchars($usuario->id)?></p>
                  </td>
                  <td class="acoesc">
                    <button class="btn-visualizar" data-id="<?= htmlspecialchars($usuario->id) ?>">
                      <i class="bi bi-eye"></i>
                    </button>
                    <button class="editar" 
                        data-id="<?= htmlspecialchars($usuario->id) ?>"
                        data-nome="<?= htmlspecialchars($usuario->nome) ?>"
                        data-email="<?= htmlspecialchars($usuario->email) ?>">
                      <i class="bi bi-pencil"></i>
                    </button>
                    <button class="deletar" data-id="<?= htmlspecialchars($usuario->id) ?>">
                      <i class="bi bi-trash"></i>
                    </button>
                  </td>
                </tr>
              <?php endforeach ?>
              </tbody>
            </table>
          </div>
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
        </div>
      </div>

      <div class="modal-criaruser hide">
        <div class="fade-criaruser"></div>
        <form class="modalc" method="POST" action="/crudUsuarios/create" enctype="multipart/form-data">
          <div class="topo-modal">
            <div class="criauser-modal">
              <img
                src="../../../public/assets/Logo-novelo.svg"
                alt=""
                class="novelo-modal"
              />
              <p>Criar Usuário</p>
            </div>
          </div>
          <div class="inputs-modal">
            <p>Nome Completo</p>
            <input type="text" name="nome" placeholder="Nome Completo" />
            <p>Tipo de Usuário</p>
            <select name="tipo" required>
              <option value="" class="seleciona" >Selecionar usuário</option>
              <option value="admin" class="typeadmin">Admin</option>
              <option value="usuario" class="typeuser">Usuário</option>
            </select>
            <p>Email</p>
            <input type="text" name="email" placeholder="Email" />
            <p>Senha</p>
            <input type="text" name="senha" placeholder="Senha" />
            <div class="foto">
              <p>Foto do Usuário</p>
              <div class="foto-container">
              <button type="button" class="foto-usuario">
                <img
                  src="../../../public/assets/adicioanar-foto.svg"
                  alt=""
                  class="adicioanar-foto"
                  id="fotoIcon"
                />
                <img src="" alt="Preview" id="fotoPreview" style="display: none;">
              </button>
              <input type="file" id="foto-usuario" name="foto" hidden />
            </div>
          </div>
          <div class="botoes-modal">
            <button type="button" class="cancelar-modal">Cancelar</button>
            <button type="submit" class="criar-modal">Criar Usuário</button>
          </div>
          </div>
        </form>
      </div>
        
      <?php foreach ($usuarios as $usuario): ?>
      <div class="fadev hide"></div>
      <div class="modal-visualizar hide" id="modal-visualizar-<?= $usuario->id ?>">
        <div class="modalv">
          <div class="topov">
            <div class="visualizacao">
              <img
                src="../../../public/assets/Logo-novelo.svg"
                alt=""
                class="novelov"
              />
              <p>Visualizar Usuário</p>
            </div>
          </div>
          <div class="container">
            <div class="identificacao">
              <div class="imagem">
            <?php if (!empty($usuario->foto) && $usuario->foto !== 'PersonCircle.svg'): ?>
  <img src="/uploads/<?= htmlspecialchars($usuario->foto) ?>" 
       alt="Foto de <?= htmlspecialchars($usuario->nome) ?>" 
       class="foto-tabela-user-modal" />
                  <?php else: ?>
                  <img src="/assets/PersonCircle.svg" alt="Sem foto"  />
                  <?php endif; ?>
              </div>
              <div class="conteudov">
                <p><?= htmlspecialchars($usuario->nome) ?></p>
                <p class="admv"><?= htmlspecialchars($usuario->tipo) ?></p>
              </div>
            </div>
            <div class="conteudov">
              <table class="tconteudo">
                <tr>
                  <td>Email</td>
                  <td><?= htmlspecialchars($usuario->email) ?></td>
                </tr>
                <tr>
                  <td>ID do Usuário</td>
                  <td><?= htmlspecialchars($usuario->id) ?></td>
                </tr>
              </table>
            </div>
            <div class="rodapev">
              <button class="fechar" data-id="<?= $usuario->id ?>">Fechar</button>
              <img
                src="../../../public/assets/Frame 76.svg"
                alt=""
                class="flor"
              />
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>

      <div class="fade-edit hide" id="fade-edit"></div>
      <div class="modal-editar hide" id="modal-editar">
        <form class="modaledit" id="modaledit" action="/crudUsuarios/edit" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="id" id="id_usuario_editar">
          <div class="topo-edit">
            <img src="../../../public/assets/Novelo_cortado.png" alt="" />
            <p>Editar Usuário</p>
          </div>

          <div class="edit-form">
            <div class="edit-nome">
              <label>Nome Completo:</label>
              <input
                type="text"
                name="nome"
                placeholder="Nome completo"
                required
              />
            </div>

            <div class="edit-email">
              <label>Novo Email:</label>
              <input type="email" name="email" placeholder="Email atual" required />
            </div>

            <div class="edit-senha">
              <label>Nova Senha:</label>
              <input
                type="password"
                name="senha"
                placeholder="Digite a nova senha"
                required
              />
            </div>

            <div class="edit-foto">
              <p>Foto do Usuário</p>
              <div class="foto-container">
                <button type="button" class="foto-usuario" id="btnFotoEdit">
                  <img src="../../../public/assets/adicioanar-foto.svg" alt="" class="nova-foto" id="fotoIconEdit" />
                  <img src="" alt="Preview" id="fotoPreviewEdit" style="display: none;">
                </button>
                <input type="file" id="inputFotoEdit" name="foto" hidden />
              </div>
            </div>

            <div class="botoes-edit">
              <button class="cancel" type="button">Cancelar</button>
              <button class="confirm" type="submit">
                Confirmar alterações
              </button>
            </div>
          </div>
        </form>
      </div>

      <div class="fade-delete hide" id="fade-delete"></div>
      <div class="modal-deletar hide" id="modal-deletar">
        <form class="modaldelete" id="modaldelete" action="/crudUsuarios/delete" method="POST">
          <input type="hidden" name="id" id="id_deletar">
          <div class="box-delete">
            <span class="vetor-atencao">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                class="lucide lucide-triangle-alert-icon lucide-triangle-alert"
              >
                <path
                  d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"
                />
                <path d="M12 9v4" />
                <path d="M12 17h.01" />
              </svg>
            </span>

            <div class="title-delete">
              <p>Deletar Usuário</p>
            </div>

            <div class="text-delete">
              <p>Você tem certeza que deseja deletar este usuário?</p>
              <p>Esta ação não poderá ser desfeita.</p>
            </div>

            <div class="button-delete">
              <button class="cancel-delete" type="button">
                Não, mantê-lo.
              </button>
              <button class="confirm-delete" type="submit">
                Sim, deletar!
              </button>
            </div>
          </div>
        </form>
      </div>
    </main>
    <script src="../../../public/js/visualizar.js"></script>
    <script src="../../../public/js/criarusuario.js"></script>
    <script src="../../../public/js/editarusuario.js"></script>
    <script src="../../../public/js/deletarusuario.js"></script>
  </body>
</html>
