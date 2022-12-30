<?php
  session_start();
  $idUsuario = $_SESSION['id'];

  if (!isset($idUsuario)) {
    header('location: index.php');
  }

  $isAdmin = $_SESSION['is_admin'];

  $user = (object) [
    'name' => 'Jane Doe',
    'email' => 'janedoe@gmail.com',
    'logged' => true
  ];
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
  <script defer="defer" src="public/js/add-prestamo/bundle/static/js/main.5c161171.js"></script>
  <link href="public/js/add-prestamo/bundle/static/css/main.371f825f.css" rel="stylesheet">

  <style type="text/css">
    .f {
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .main-container {
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
              <button type="button" class="btn-atras mrgn-left" onclick="location.href='home.php'">Atrás</button>
          </span>
      </div>

      <div class="title-wrapper f-center">
          <span class="t-medium">
              Agregar Dispositivo
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
      <div id="root" data-usuario="<?= $idUsuario ?>"></div>
    </main>
  </div>
</body>
</html>
