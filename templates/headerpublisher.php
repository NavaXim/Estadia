<?php
$url_base = "https://andradem.net/inventarios/";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="icon" href="<?php echo $url_base ?>img/favicon.ico" type="image/x-icon">

    <!-- Bootstrap CSS Libraries -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.1/css/all.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <script src="https://code.jquery.com/jquery-3.6.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="<?php echo $url_base ?>css/style.css">
    
    
    <title>Sistema de control de Inventarios</title>
    
</head>

<body style="background: azure">
    <?php
    // Iniciar la sesión
    session_start();
    
    // Recuperar la variable de la sesión
    if (!isset($_SESSION['nombre'])) {
        include('header.php');
        include('footer.php');
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                Swal.fire({
                    title: "Sin acceso",
                    text: "¡Es necesario Iniciar Sesión!",
                    icon: "info",
                }).then(function() {
                    // Redirigir a otra página
                    window.location.href = "../";
                });        
            </script>';
            exit();
    }
    ?>

   <header>
       <img src="<?php echo $url_base ?>img/top.png" alt="Logo de tu sitio web">
    </header>
    
    <main>
    
        <nav class="navbar navbar-expand-sm navbar-dark bg-dark">

            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">Inventarios</a>
                <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="collapsibleNavId">
                    <ul class="navbar-nav me-auto mt-2 mt-lg-0">
                        <!--
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Configuración</a>
                            <div class="dropdown-menu" aria-labelledby="dropdownId">
                                <a class="dropdown-item" href="">Usuarios</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Catalogos</a>
                            <div class="dropdown-menu" aria-labelledby="dropdownId">
                                <a class="dropdown-item" href="areas.php">Áreas</a>
                                <a class="dropdown-item" href="#">Tipo de bien</a>
                            </div>
                        </li>-->
                        <li class="nav-item">
                            <a class="nav-link" href="#">Movimientos</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i> <?php echo $_SESSION['nombre']; ?></a>
                            <div class="dropdown-menu" aria-labelledby="dropdownId">
                                <a class="dropdown-item" href="../../">Cerrar Sesión</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <br>
    