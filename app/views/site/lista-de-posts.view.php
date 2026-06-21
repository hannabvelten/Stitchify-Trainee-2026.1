<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Posts</title>
    <link rel="stylesheet" href="../../../public/css/lista-de-posts.css">
    <link rel="icon" type="image/png" href="../../../public/assets/Novelo_logo_3.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <div class="navbar">
        <?php require("app/views/site/navbar.php")?>
    </div>
    <main>
        <div class="barra-de-pesquisa">
            <div class="busca">
                <h2>Buscar</h2>
                <div class="search-filter">
                    <span class="link-search">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-search-icon lucide-search">
                            <path d="m21 21-4.34-4.34" />
                            <circle cx="11" cy="11" r="8" />
                        </svg>
                    </span>
                    <div class="filter">
                        <span class="link-filter">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-list-filter-icon lucide-list-filter">
                                <path d="M2 5h20" />
                                <path d="M6 12h12" />
                                <path d="M9 19h6" />
                            </svg>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="titulo">
            <h1>Nossos Posts</h1>
        </div>

        <div class="div-cards">
            <?php foreach ($posts as $post): ?>
                <article class="card-unit">
                    <div class="div-img">
                        <img src="../../../public/assets/posts/<?= htmlspecialchars($post->imagem) ?>" alt="<?= htmlspecialchars($post->titulo) ?>">
                    </div>
                    <div class="conteudo-card">
                        <h3 class="titulo-post"><?= htmlspecialchars($post->titulo) ?></h3>
                        <div class="texto-post">
                            <p><b>Autor: </b><?= htmlspecialchars($post->nome_autor) ?></p>
                            <p><?= htmlspecialchars($post->descricao) ?></p>
                        </div>
                        <a href="/Post-individual?id_post=<?= $post->id_post ?>" class="botao-ver-mais">Ver mais</a>
                    </div>
                </article>
            <?php endforeach; ?>
            <!-- <article class="card-unit">
                <div class="div-img">
                    <img src="../../../public/assets/flor.webp" alt="Descrição da imagem 2">
                </div>
                <div class="conteudo-card">
                    <h3 class="titulo-post">Lorem ipsum</h3>
                    <div class="texto-post">
                        <p><b>Autor: </b></p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse imperdiet maximus
                            sodales.</p>
                    </div>
                    <button class="botao-ver-mais">Ver mais</button>
                </div>
            </article>

            <article class="card-unit">
                <div class="div-img">
                    <img src="../../../public/assets/flor.webp" alt="Descrição da imagem 3">
                </div>
                <div class="conteudo-card">
                    <h3 class="titulo-post">Lorem ipsum</h3>
                    <div class="texto-post">
                        <p><b>Autor: </b></p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse imperdiet maximus
                            sodales.</p>
                    </div>
                    <button class="botao-ver-mais">Ver mais</button>
                </div>
            </article>

            <article class="card-unit">
                <div class="div-img">
                    <img src="../../../public/assets/flor.webp" alt="Descrição da imagem 4">
                </div>
                <div class="conteudo-card">
                    <h3 class="titulo-post">Lorem ipsum</h3>
                    <div class="texto-post">
                        <p><b>Autor: </b></p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse imperdiet maximus
                            sodales.</p>
                    </div>
                    <button class="botao-ver-mais">Ver mais</button>
                </div>
            </article>

            <article class="card-unit">
                <div class="div-img">
                    <img src="../../../public/assets/flor.webp" alt="Descrição da imagem 5">
                </div>
                <div class="conteudo-card">
                    <h3 class="titulo-post">Lorem ipsum</h3>
                    <div class="texto-post">
                        <p><b>Autor: </b></p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse imperdiet maximus
                            sodales.</p>
                    </div>
                    <button class="botao-ver-mais">Ver mais</button>
                </div>
            </article>

            <article class="card-unit">
                <div class="div-img">
                    <img src="../../../public/assets/flor.webp" alt="Descrição da imagem 6">
                </div>
                <div class="conteudo-card">
                    <h3 class="titulo-post">Lorem ipsum</h3>
                    <div class="texto-post">
                        <p><b>Autor: </b></p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse imperdiet maximus
                            sodales.</p>
                    </div>
                    <button class="botao-ver-mais">Ver mais</button>
                </div>
            </article> -->

        </div>
        
        <?php if($totalPages > 1): ?>
            <div class="paginacao">
                <a href="?page=<?= max(1, $currentPage - 1) ?>" class="<?= $currentPage <= 1 ? 'disabled' : '' ?>"><i class="bi bi-chevron-left"></i></a>
                
                <?php
                    $start = max(2, $currentPage - 1);
                    $end = min($totalPages - 1, $currentPage + 1);
                ?>

                <a href="?page=1" class="<?= $currentPage == 1 ? 'ativo' : '' ?>">1</a>

                <?php if ($start > 2): ?>
                    <span class="points">...</span>
                <?php endif; ?>

                <?php for ($i = $start; $i <= $end; $i++): ?>
                    <a href="?page=<?= $i ?>" class="<?= $currentPage == $i ? 'ativo' : '' ?>"><?= $i ?></a>
                <?php endfor; ?>

                <?php if ($end < $totalPages - 1): ?>
                    <span class="points">...</span>
                <?php endif; ?>

                <a href="?page=<?= $totalPages ?>" class="<?= $currentPage == $totalPages ? 'ativo' : '' ?>"><?= $totalPages ?></a>

                <a href="?page=<?= min($totalPages, $currentPage + 1) ?>" class="<?= $currentPage >= $totalPages ? 'disabled' : '' ?>"><i class="bi bi-chevron-right"></i></a>

                
                <!-- <button>
                    <i class="bi bi-chevron-left"></i>
                </button>

                <button class="ativo">1</button>

                <button>2</button>

                <button>3</button>

                <span class="points">...</span>

                <button>6</button>

                <button>
                    <i class="bi bi-chevron-right"></i>
                </button> -->

            </div>
        
        <?php endif; ?>
        
    </main>
    <div class="footer">
        <?php require("app/views/site/footer.php")?>
    </div>
    
</body>
</html>