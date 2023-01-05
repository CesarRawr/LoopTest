<!DOCTYPE html>

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
?>

<?php

include_once('./public/php/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $database = new Connection();
  $db = $database->open();

  if (isset($_POST['add_device'])) {
    try{
      $nombre = $_POST["nombre_usuario"];
      $apellido = $_POST["apellido_usuario"];
      $nickname = $_POST["nickname_usuario"];
      $contra = $_POST["contra_usuario"];
      $admin = $_POST["is_admin"];

      if (empty($nombre) || empty($apellido) || empty($nickname) || empty($contra)) {
        $_SESSION['message'] = "No deje campos vacios";  
      } else {
        /* Revisar si existe el nickname */
        $_GRABAR_SQL = "SELECT * FROM usuario WHERE nickname='$nickname'";
        $data = $db->query( $_GRABAR_SQL);
        $hi = $data -> fetchAll();

        if(sizeof($hi) === 0){
          //Guardar
          $_GRABAR_SQL = "INSERT INTO usuario (nombre, apellido, nickname, contrasena, is_admin) VALUES('$nombre', '$apellido', '$nickname', '$contra', '$admin')";
          $data = $db->query( $_GRABAR_SQL);
          $hi = $data -> fetchAll();

          if(!$hi){
            $_SESSION['message'] = "Usuario guardado con éxito";
            $_SESSION['success'] = true;
          } else{
            $_SESSION['message'] = "Error al guardar el usuario";   
          }
        } else{
          $_SESSION['message'] = "El nickname que intenta usar, ya se encuentra ocupado";   
        }
      }
    } catch(PDOException $e){
      $_SESSION['message'] = "Error al conectarse con la base de datos";   
    }
  }
}
?>

<html lang="es">

  <head>

    <meta charset="utf-8">
    <title>Préstamos UV</title>

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
    <link rel="stylesheet" type="text/css" href="public/css/mod-dispositivos/mod-dispositivos.css">
    <link rel="stylesheet" type="text/css" href="public/css/lista-prestamos/header.css">

  
    <style>
      .loans-container {
        display: flex;
        align-items: center;
        justify-content: space-around;
        flex-flow: row;
      }

      .btn-atras:hover {
        transition: all .2s ease-out 0s;
      }

      .btn-atras:hover {
        filter: brightness(.97);
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
                Agregar Usuario
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
        <div class="loans-container scrollbar f-center">
          <div>
            <img width="250" src="images/verde.png" style="margin-bottom: 15vh;">
          </div>
          <div class="add-card">
            <form autocomplete="off" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">

              <div class="field">
                <label class="label">Nombre</label>
                <div class="control">
                  <input class="input" type="text" id="nombre" name="nombre_usuario" placeholder="Nombre">
                </div>
              </div>

              <div class="field">
                <label class="label">Apellido</label>
                <div class="control">
                  <input class="input" type="text" id="apellido" name="apellido_usuario" placeholder="Apellido">
                </div>
              </div>

              <div class="field">
                <label class="label">Nickname</label>
                <div class="control">
                  <input class="input" type="text" id="nickmane" name="nickname_usuario" placeholder="Nickname">
                </div>
              </div>

              <div class="field">
                <label class="label">Contraseña</label>
                <div class="control">
                  <input class="input" type="text" id ="contraseña" name="contra_usuario" placeholder="Contraseña">
                </div>
              </div>

              <div class="field control-selector">
                <label class="label" style="margin: 0;">¿Dar permisos de admin?</label>
                <div class="control">
                  <div class="select">
                    <select name="is_admin">
                      <option value="1">Sí</option>
                      <option value="0">No</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="f-center">
                <input class="btn-atras" type="submit" value="Agregar" name="add_device">
              </div>

            </form>
          </div>
          <div>
            <img width="250" src="images/verde.png" style="margin-bottom: 15vh;">
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
                          <button class="button is-success" onclick="location.href='home.php'">Aceptar</button>
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

