<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../../public/css/inscreva-se.css">
</head>
<body>
    <main>

    <div class="onda-container">

        <div class="saudacao">
            <h3>Bem-vindo</h3>

            <h2>
                à sua <span>criatividade</span>
            </h2>

            <p>
              Crie sua conta e comece a criar <br>
                peças únicas com os fios
            </p>
        </div>

        <img src="../../../public/assets/onda-mobile.png"
             class="onda-mobile"
             alt="">
        
    </div>

    <div class="login-container">

        <div class="logo">
            <img class="imagem-logo"
                 src="../../../public/assets/logo-stitchify.png"
                 alt="logo stitchify">
                 <div class="criar-conta">
            <div class="criar-conta">
            <img src="../../../public/assets/linha-direita.svg" alt="">
            <h3>Crie sua conta</h3> <img src="../../../public/assets/linha-esquerda.svg" alt="">
            </div>
        </div>
        </div>
        <div class="saudacao-mobile">
            <h3>Bem-vindo</h3>
            <h2>
                à sua <span>criatividade</span>
            </h2>

            <p>
                Crie sua conta e comece a criar
                peças únicas com os fios
            </p>
        </div>

        <form action="/inscreva-se" method="POST" class="inputs">
        <div class="mensagem-erro">
            <p>
            <?php
                if(isset($_SESSION['mensagem-erro']))
                echo $_SESSION['mensagem-erro'];
                session_unset();
                ?>
            </p>
        </div>
            <input type="email" name="email" placeholder="Email">

            <input type="password" name="senha" placeholder="Senha">
            <input type="password" name="confirmarSenha" placeholder="Confirmar senha">

            <button type="submit">
                Inscreva-se
            </button>
        </form>

        <div class="inscricao">
            <p>
                Já tem conta?
                <a href="http://localhost:8000/login">Entrar</a>
            </p>
        </div>

    </div>

</main>
</body>
</html>