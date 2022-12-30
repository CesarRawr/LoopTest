<?php
  session_start();
  $isAdmin = $_SESSION['is_admin'];

  if (!isset($isAdmin)) {
    header('location: index.php');
    return;
  }
?>

<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Préstamos UV</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <link rel="stylesheet" type="text/css" href="public/css/reset.css">
    <link rel="stylesheet" type="text/css" href="public/css/home.css">

    <style>
        .material-symbols-outlined {
          font-variation-settings:
          'FILL' 1,
          'wght' 400,
          'GRAD' 0,
          'opsz' 48
        }

        .md-med-size {
            font-size: 80px;
        }

        .md-white {
            color: #fff;
        }

        .filter-white {
            filter: brightness(0) invert(1);
        }
    </style>
</head>
<body>
    <div class="container-home">
        <div class="header">
            <div class="title-wrapper">
                <span class="logo-op">
                    
                </span>
            </div>

            <div class="title-wrapper f-center">
                <span class="t-medium">
                    Inicio
                </span>
            </div>

            <div class="title-wrapper f-end">
                <span class="t-medium">
                    <button type="button" class="btn-salir mrgn-right" onclick="location.href='logout.php'">Cerrar Sesión</button>
                </span>
            </div>
        </div>    
        
        <main>
            <?php 
                if ($isAdmin === 1) {
                    ?>
                        <!-- Usuario card -->
                        <div class="card br-10 mrgn-btm bg-light-green">
                            <header class="purple">
                                <img src="images/group.svg" width="80" height="80" class="icon filter-white" />
                                <span class="t-medium">
                                    Usuarios
                                </span>
                            </header>

                            <section class="option-list-container">
                                <ul>
                                    <li>
                                        <a class="purple-hover purple-border" href="add_usuario.php">Crear Usuario</a>
                                    </li>
                                    <li>
                                        <a class="purple-hover purple-border" href="lista_usuarios.php">Ver Lista de Usuarios</a>
                                    </li>
                                </ul>
                            </section>
                        </div>
                    <?php
                }
            ?>

            <!-- Préstamos card -->
            <div class="card br-10 mrgn-tp">
                <header class="purple-pink">
                    <img class="icon" src="images/book.svg" width="80" height="80"/>
                    <span class="t-medium">
                        Préstamos
                    </span>
                </header>

                <section class="option-list-container">
                    <ul>
                        <li>
                            <a class="purple-pink-hover purple-pink-border" href="add_prestamo.php">Crear Préstamo </a>
                        </li>
                        <li>
                            <a class="purple-pink-hover purple-pink-border" href="mis_prestamos.php">Ver Mis Préstamos</a>
                        </li>
                        <li>
                            <a class="purple-pink-hover purple-pink-border" href="lista_prestamos.php">Ver Préstamos Activos</a>
                        </li>

                        <?php 
                            if ($isAdmin === 1) {
                                ?>
                                    <li>
                                        <a class="purple-pink-hover purple-pink-border" href="all_prestamos.php">Ver Todos los Préstamos</a>
                                    </li>
                                <?php
                            }
                        ?>
                    </ul>
                </section>
            </div>

            <?php 
                if ($isAdmin === 1) {
                    ?>
                        <!-- Dispositivos card -->
                        <div class="card br-10 mrgn-btm bg-light-blue">
                            <header class="pink">
                                <img src="images/devices.svg" width="80" height="80" class="icon filter-white" />
                                <span class="t-medium">
                                    Dispositivos
                                </span>
                            </header>

                            <section class="option-list-container">
                                <ul>
                                    <li>
                                        <a class="pink-hover pink-border" href="add_device.php">Crear Dispositivo</a>
                                    </li>
                                    <li>
                                        <a class="pink-hover pink-border" href="lista_dispositivos.php">Ver Lista de Dispositivos</a>
                                    </li>
                                </ul>
                            </section>
                        </div>
                    <?php
                }
            ?>
        </main>
    </div>

    <script type="text/javascript" src="public/js/home.js"></script>

    <!-- Boostrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
