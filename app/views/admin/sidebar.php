<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../public/css/sidebar.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <title>Sidebar</title>
</head>

<body>

    <div class="sidebar">

        <div class="botao-sidebar">
            <i class="bi bi-caret-left-fill toggle left"></i>
            <i class="bi bi-caret-right-fill toggle right"></i>
        </div>

        <div class="logo">
            <a href="/">
                <img src="../../../public/assets/logo.png" alt="" class="stitchify">
                <img src="../../../public/assets/Novelo_logo_3.png" alt="" class="novelo">
            </a>
                
        </div>

        <div class="paginas">
            <div class="link-paginas">
                <a href="/dashboard">
                    <div class="link">
                        <i class="bi bi-bar-chart-fill"></i>
                        <p>Dashboard</p>
                    </div>
                </a>
                <a href="/tabelapost">
                    <div class="link">
                        <i class="bi bi-file-richtext-fill"></i>
                        <p>Posts</p>
                    </div>
                </a>
                <a href="/crudUsuarios">
                    <div class="link">
                        <i class="bi bi-people-fill"></i>
                        <p>Usuários</p>
                    </div>
                </a>
                    
            </div>
                

            <div class="logout">
                <a href="/logout">
                    <div class="link">
                        <i class="bi bi-box-arrow-right"></i>
                        <p>Logout</p>
                    </div>
                </a>
                    
            </div>
                

        </div>

    </div>

    <script src="../../../public/js/sidebar.js"></script>

</body>

</html>