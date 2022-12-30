<?php
  session_start();
  $idUsuario = $_SESSION['id'];
  $isAdmin = $_SESSION['is_admin'];

  if (!isset($idUsuario)) {
    header('location: index.php');
    return;
  }

  include_once('public/php/lista-prestamos/PrestamosController.php');
  $controller = new PrestamosController();
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id='';
    foreach($_POST as $name => $content) {
      $id = $name;
    }

    $res = $controller->regresarPrestamo($id);
    if (!is_null($res)) {
      if ($res) {
        $_SESSION['message'] = "Se ha regresado correctamente el préstamo";
        $_SESSION['success'] = true;
      } else if ($res) {
        $_SESSION['message'] = "Error en el servidor al intentar regresar el préstamo";
      }
    }
  }
  
  $prestamos = $controller->getPrestamosInfo();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Lista de préstamos</title>

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
    .loans-container table tr td ul li {
      color: #616161;
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
              Préstamos Activos
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
        <div class="table-background scrollbar <?php echo (sizeof($prestamos) == 0) ? "f-center": "";?>">
          <?php 
            if (sizeof($prestamos) == 0) {
              ?>
                <span class="t-medium" style="color: #28AD56; font-size: 20px;">No hay préstamos activos para mostrar</span>
              <?php                
            }
          ?>

          <?php 
            if (sizeof($prestamos) > 0) {
              ?>
                <table>
                  <tr>
                    <th>Profesor</th>
                    <th>EE</th>
                    <th>Aula</th>
                    <th>Hora de Inicio</th>
                    <th>Hora de entrega</th>
                    <th>Fecha</th>
                    <th style="width: 18%;">Dispositivos</th>
                    <th>Alumno</th>
                    <th>Acciones</th>
                  </tr>

                  <?php 
                  foreach ($prestamos as $prestamo) { 
                    ?>
                    <tr>
                      <td><?= $prestamo['profesor'][0]['nombre'] ?> </td>
                      <td><?= $prestamo['materia'][0]['nombre'] ?> </td>
                      <td><?= $prestamo['aula'][0]['nombre'] ?> </td>
                      <td><?= $prestamo['horario_entrada'] ?> </td>
                      <td><?= $prestamo['horario_salida'] ?> </td>
                      <td><?= $prestamo['fecha'] ?> </td>
                      <td>
                        <ul>
                          <?php 
                          foreach($prestamo['dispositivos'] as $dispositivo) {
                            echo "
                            <li>{$dispositivo['nombre']} ({$dispositivo['prestado']})</li>
                            ";
                          }
                          ?>
                        </ul>
                      </td>
                      <td>
                        <?php 
                        if($prestamo['id_alumno'] !== NULL) {
                          echo $prestamo['alumno'];
                        } 
                        ?> 
                      </td>
                      <td>
                        <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
                          <input class="btn-salir" type="submit" value="Devolver" name="<?= $prestamo['id'] ?>">
                        </form>
                      </td>
                    </tr>
                    <?php
                  }
                  ?>
                </table>
              <?php                
            }
          ?>
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
