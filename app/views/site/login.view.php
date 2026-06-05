<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Login</title>
    <link rel="stylesheet" href="../../../public/css/login.css">
</head>

<body>
    <main>
       <div class="onda-container">
        <div class="saudacao">
            <h3>Bem vindo de volta</h3>
            <h2>à sua <span>criatividade</span></h2>
            <p>Entre na sua conta e continue criando <br>
                peças únicas com os fios
            </p>
        </div>
        <img src="../../../public/assets/onda-mobile.png" alt="" class="onda-mobile">
       </div>
       <div class="login-container">
            <div class="logo">
                    <img  class="imagem-logo" src="../../../public/assets/logo-stitchify.png" alt="logo-stitchify">
            </div>
            <div class="saudacao-mobile">
                <h3>Bem vindo de volta</h3>
            <h2>à sua <span>criatividade</span></h2>
            <p>Entre na sua conta e continue criando 
                peças únicas com os fios
            </p>
            </div>
       <div class="inputs">
        <form action="/login" method="POST">
        <div class="mensagem-erro">
            <p>
            <?php
                if(isset($_SESSION['mensagem-erro']))
                echo $_SESSION['mensagem-erro'];
                session_unset();
                ?>
            </p>
        </div>
            <input type="email" name="email "placeholder="Email">
            <input type="password" name="senha" placeholder="Senha">
            <button type="submit">Entrar</button>
       </div>
       </form>
       <div class="inscricao">
        <p>Ainda não tem conta? <a href="inscreva-se.html">Inscreva-se</a></p>
       </div>
       </div>
    </main>
</body>

</html>