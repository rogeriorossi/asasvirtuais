<?php
$currentPage = isset($_GET['page']) ? $_GET['page'] : 'home';
?>
<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Asas Virtuais | Simulação de Voo & Tutoriais</title>
    <meta name="description" content="Asas Virtuais é o seu canal de simulação de voo. Tutoriais, gameplays e conteúdo de aviação virtual."/>
    <meta name="keywords" content="asas virtuais, simulação de voo, x-plane, msfs2020, flight simulator, aviação virtual, zibo mod"/>
    <meta name="author" content="Rogerio Rossi">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="./assets/img/AV-Logo-new-transp.png">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Custom Styles -->
    <link type="text/css" rel="stylesheet" href="./assets/css/style.css"/>
</head>

<body class="bg-dark text-light d-flex flex-column min-vh-100">
    <!-- Menu Flutuante Estilo Pill que Rola Junto com a Página -->
    <header class="py-3 header-floating-wrapper">
        <div class="container">
            <nav class="navbar navbar-expand-lg custom-navbar-floating rounded-pill px-3 px-md-4 py-2 shadow-lg">
                <a class="navbar-brand brand-logo me-3" href="./index.php">
                    <img src="./assets/img/AV-Logo-new-transp.png" alt="Asas Virtuais Logo" height="42">
                </a>

                <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Alternar navegação">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarContent">
                    <ul class="navbar-menu navbar-nav mx-auto mb-2 mb-lg-0 gap-lg-2">
                        <li class="nav-item">
                            <a class="nav-link text-uppercase fw-semibold px-3 <?php echo $currentPage === 'home' ? 'active' : ''; ?>" href="./index.php">Vídeos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-uppercase fw-semibold px-3" href="https://www.youtube.com/@asasvirtuais/playlists" target="_blank" rel="noopener">
                                Playlists <i class="bi bi-box-arrow-up-right ms-1 opacity-75 small"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-uppercase fw-semibold px-3 <?php echo $currentPage === 'sobre' ? 'active' : ''; ?>" href="./index.php?page=sobre">Sobre</a>
                        </li>
                    </ul>

                    <div class="d-flex align-items-center">
                        <a href="https://www.youtube.com/@asasvirtuais" target="_blank" rel="noopener" class="btn btn-danger btn-yt-custom d-inline-flex align-items-center gap-2 fw-semibold shadow-sm rounded-pill px-3 py-2">
                            <i class="bi bi-youtube fs-5"></i>
                            <span>Inscrever-se</span>
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </header>