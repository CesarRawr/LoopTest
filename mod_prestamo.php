<?php
  session_start();
  $idUsuario = $_SESSION['id'];

  if (!isset($idUsuario)) {
    header('location: index.php');
  }

  $idPrestamo = $_GET['id'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Lista de dispositivos</title>

  <!-- Google Icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <!-- Google Roboto Font -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

  <!-- Misc css -->
  <link rel="stylesheet" type="text/css" href="public/css/reset.css">
  <link rel="stylesheet" type="text/css" href="public/css/add-prestamo/add-prestamo.css">
  <link rel="stylesheet" type="text/css" href="public/css/lista-prestamos/lista-prestamos.css">
  <link rel="stylesheet" type="text/css" href="public/css/lista-prestamos/header.css">

  <!-- React compilado -->
  <script defer="defer" src="public/js/mod-loan/static/js/main.ed1fe1b9.js"></script>
  <link href="public/js/mod-loan/static/css/main.371f825f.css" rel="stylesheet">

  <style type="text/css">
    .f {
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .main-container {
      background-color: #e2edfa;
      grid-template-rows: 82vh 1fr !important;
    }

    #root {
      display: grid;
    }
  </style>
</head>
<body>
  <div class="container-main">
    <header>
      <div class="title-wrapper f-start">
          <span>
              <button type="button" class="btn-atras mrgn-left" onclick="history.back()">Atrás</button>
          </span>
      </div>

      <div class="title-wrapper f-center">
          <span class="t-medium">
              Crear Préstamo
          </span>
      </div>

      <div class="title-wrapper f-end">
          <span>
              <button type="button" class="btn-salir mrgn-right" onclick="location.href='logout.php'">Cerrar Sesión</button>
          </span>
      </div>
    </header>

    <!-- Main Section -->
    <main class="main-container">
      <div id="root" data-usuario="<?= $idUsuario ?>" data-prestamo="<?= $idPrestamo ?>"></div>
    </main>
  </div>
</body>
</html>
