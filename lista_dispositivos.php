<?php
  session_start();
  $isAdmin = $_SESSION['is_admin'];

  if (!isset($isAdmin)) {
    header('location: index.php');
    return;
  }

  if (!boolval($isAdmin)) {
    echo "Solo administradores";
    return;
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['del_device'])) {
      $id = $_POST['id'];

      include_once('public/php/mod-dispositivos/ModDispositivoController.php');
      $controllerMod = new ModDispositivoController();
      $res = $controllerMod -> delDispositivo($id);

      if ($res['success']) {
        $_SESSION['message'] = $res['msg'];
        $_SESSION['success'] = true;
      } else {
        $_SESSION['message'] = $res['msg'];
      }
    }
  }

  include_once('public/php/lista-dispositivos/DispositivosController.php');

  $controller = new DispositivosController();
  $dispositivos = $controller->getDispositivosInfo();
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

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">

  <!-- Misc css -->
  <link rel="stylesheet" type="text/css" href="public/css/reset.css">
  <link rel="stylesheet" type="text/css" href="public/css/lista-prestamos/lista-prestamos.css">
  <link rel="stylesheet" type="text/css" href="public/css/lista-prestamos/header.css">

  <style type="text/css">
    .container-main {
      background-color: #e2edfa;
    }

    /* lighten 90% */
    .table-background {
      background-color: #e2edfa;
    }

    /* lighten 80% */
    tr:nth-child(odd) {
      background-color: #c5dbf6;
    }

    .loans-container table td, th {
      color: #616161;
    }

    /* lighten 75% */
    .loans-container table tr:hover {
      background-color: #b7d2f4;
    }

    /* lighten 70% */
    .loans-container table tbody tr th {
      background-color: #70a5e9;
    }

    /* lighten 70% */
    .scrollbar::-webkit-scrollbar-track {
      background: #a9c9f1;
    }

    /* lighten 50% */
    .scrollbar::-webkit-scrollbar-thumb {
      background: #70a5e9;
      border-radius: 15px;
    }

    /* lighten 40% */
    .scrollbar::-webkit-scrollbar-thumb:hover {
      background: #5393e4;
    }
  </style>
</head>
<body>
  <div class="container-main">
    <!-- Header -->
    <header>
      <div class="title-wrapper f-start">
          <span>
              <button type="button" class="btn-atras mrgn-left" onclick="location.href='home.php'">Atrás</button>
          </span>
      </div>

      <div class="title-wrapper f-center">
          <span class="t-medium">
              Lista de dispositivos
          </span>
      </div>

      <div class="title-wrapper f-end">
          <span>
              <button type="button" class="btn-salir mrgn-right" onclick="location.href='logout.php'">Cerrar Sesión</button>
          </span>
      </div>
    </header>

    <!-- Main Section -->
    <main>
      <!-- Loans Table -->
      <div class="loans-container">
        <div class="table-background scrollbar">
          <table>
            <tr>
              <th style="width: 10%;">ID</th>
              <th style="width: 22%;">Nombre</th>
              <th style="width: 18%;">Cantidad</th>
              <th style="width: 22%;">Observaciones</th>
              <th style="width: 18%;">Acciones</th>
            </tr>

            <?php 
              foreach ($dispositivos as $dispositivo) { 
                ?>
                <tr>
                  <td><?= $dispositivo['id'] ?> </td>
                  <td><?= $dispositivo['nombre'] ?> </td>
                  <td><?= $dispositivo['cantidad']-$dispositivo['prestado'] ?> </td>
                  <td><?= $dispositivo['observaciones'] ?> </td>
                  <td>
                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
                      <input type="hidden" name="id" value="<?php echo $dispositivo['id']?>">

                      <button style="background: #fafafa;color: #616161;border: 1px solid #e0e0e0;" type="button" class="btn-atras mrgn-right" onclick="location.href='/prestamos/mod_dispositivos.php?id=<?= $dispositivo['id'] ?>'">Editar</button>
                      <button type="submit" class="btn-salir" name="del_device">Borrar</button>
                    </form>
                  </td>
                </tr>
                <?php
              }
            ?>
          </table>
        </div>
      </div>
    </main>
  </div>

  <!-- Modal -->
  <?php 
      if(isset($_SESSION['message'])){
          ?>
            <!-- Intento de modal -->
            <div class="modal is-active">
              <div class="modal-background"></div>
              <div class="modal-content">
                <header class="modal-card-head">
                  <p class="modal-card-title">Alerta</p>
                  <button class="delete" aria-label="close"></button>
                </header>
                <section class="modal-card-body">
                  <?php echo $_SESSION['message']; ?>
                </section>
                <footer class="modal-card-foot">
                  <?php 
                    if(isset($_SESSION['success'])){
                      ?>
                        <button class="button is-success">Aceptar</button>
                      <?php
                      unset($_SESSION['success']);
                    } else {
                      ?>
                        <button class="button is-danger">Cerrar</button>
                      <?php
                    }
                  ?>
                </footer>
              </div>
              <button class="modal-close is-large" aria-label="close"></button>
            </div>
          <?php

          unset($_SESSION['message']);
      }
  ?>

  <!-- Modal Script -->
  <script type="text/javascript">
    document.addEventListener('DOMContentLoaded', () => {
      // Functions to open and close a modal
      function openModal($el) {
        $el.classList.add('is-active');
      }

      function closeModal($el) {
        $el.classList.remove('is-active');
      }

      function closeAllModals() {
        (document.querySelectorAll('.modal') || []).forEach(($modal) => {
          closeModal($modal);
        });
      }

      // Add a click event on buttons to open a specific modal
      (document.querySelectorAll('.js-modal-trigger') || []).forEach(($trigger) => {
        const modal = $trigger.dataset.target;
        const $target = document.getElementById(modal);

        $trigger.addEventListener('click', () => {
          openModal($target);
        });
      });

      // Add a click event on various child elements to close the parent modal
      (document.querySelectorAll('.modal-background, .modal-close, .modal-card-head .delete, .modal-card-foot .button') || []).forEach(($close) => {
        const $target = $close.closest('.modal');

        $close.addEventListener('click', () => {
          closeModal($target);
        });
      });

      // Add a keyboard event to close all modals
      document.addEventListener('keydown', (event) => {
        const e = event || window.event;

        if (e.keyCode === 27) { // Escape key
          closeAllModals();
        }
      });
    });
  </script>
</body>
</html>

