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
    
  include_once('./public/php/connection.php');
  $database = new Connection();
  $db = $database->open();

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_device'])) {
      try{
          $id = $_POST["id_usuario"];
          $nombre = $_POST["nombre_usuario"];
          $apellido = $_POST["apellido_usuario"];
          $nickname = $_POST["nickname_usuario"];
          $contra = $_POST["contra_usuario"];
          $admin = $_POST["is_admin"];

          $actualNombre = $_POST["actual_nombre_usuario"];
          $actualApellido = $_POST["actual_apellido_usuario"];
          $actualNickname = $_POST["actual_nickname_usuario"];
          $actualContra = $_POST["actual_contra_usuario"];
          $actualAdmin = $_POST["actual_is_admin"];

          // si no se modificó algún campo
          if ($actualNombre === $nombre && $actualApellido === $apellido && $actualNickname === $nickname && $actualContra === $contra && $actualAdmin === $admin) {
            $_SESSION['actualID'] = $id;
            $_SESSION['message'] = "No se modificó algún campo";
          } else {
            // Si hay campos vacios
            if (empty($nombre) || empty($apellido) || empty($nickname)) {
              $_SESSION['actualID'] = $id;
              $_SESSION['message'] = "No dejes campos vacios";
            } else {
              /* Revisar si existe el nickname */
              $_GRABAR_SQL = "SELECT * FROM usuario WHERE nickname='$nickname' AND id!='$id'";
              $data = $db->query( $_GRABAR_SQL);
              $hi = $data -> fetchAll();

              if(sizeof($hi) === 0){
                $_GRABAR_SQL = "UPDATE usuario SET nombre='$nombre', apellido='$apellido', nickname='$nickname', contrasena='$contra', is_admin='$admin' WHERE id='$id'";
                $data = $db->query( $_GRABAR_SQL);  
                $hi = $data->fetchAll();

                if(!$hi){
                  $_SESSION['actualID'] = $id;
                  $_SESSION['message'] = "Usuario modificado con éxito";
                  $_SESSION['success'] = true;
                } else{
                  $_SESSION['actualID'] = $id;
                  $_SESSION['message'] = "Error al intentar modificar un usuario";
                }
              } else{
                $_SESSION['actualID'] = $id;
                $_SESSION['message'] = "El nickname que intentó usar, ya se encuentra ocupado";
              }
            }
          }
      } catch(PDOException $e){
          $_SESSION['actualID'] = $id;
          $_SESSION['message'] = "Error al conectar con el servidor";
      }
    }

    if (isset($_POST['del_device'])) {

      try{
        $id = $_POST["id_usuario"];
        
        $_GRABAR_SQL = "DELETE FROM usuario WHERE id='$id'";
        $data = $db->query( $_GRABAR_SQL);  
        $hi = $data -> fetchAll();

        if(!$hi){
          $_SESSION['actualID'] = $id;
          $_SESSION['message'] = "Usuario eliminado con éxito";
          $_SESSION['success'] = true;
        } else{
          $_SESSION['actualID'] = $id;
          $_SESSION['message'] = "Error al eliminar el usuario";
        }
          
      } catch(PDOException $e){
        $_SESSION['actualID'] = $id;
        $_SESSION['message'] = "Error al conectar con la base de datos";   
      }
    }
  }
?>

<?php
    $idUsuario;

    if (!isset($_GET['id']) && !isset($_POST['id'])) {
      $idUsuario = $_SESSION['actualID'];
    } else {
      $idUsuario = array_key_exists("id", $_GET) ? $_GET['id']: $_POST['id'];
    }

    try {
      $consulta = "SELECT * FROM usuario WHERE id='$idUsuario'";
      $datos = $db->query( $consulta);  
      $result = $datos->fetchALL();

      $nombreid = $result[0]["nombre"];
      $apellidoid = $result[0]["apellido"];
      $nicknameid = $result[0]["nickname"];
      $contraid = $result[0]["contrasena"];
      $adminid = $result[0]["is_admin"];

      if($adminid == 1){

        $value1 = 1;
        $var1 = "Sí";
        $value2 = 0;
        $var2 = "No";

      } else{

        $value1 = 0;
        $var1 = "No";
        $value2 = 1;
        $var2 = "Sí";
      }
    } catch (Exception $e) {
      echo "<SCRIPT> alert('Algo salió mal'); document.location=('lista_usuarios.php'); </SCRIPT>";
    }
?>

<!DOCTYPE html>
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
    <link rel="stylesheet" type="text/css" href="public/css/lista-prestamos/header.css">
    <link rel="stylesheet" type="text/css" href="public/css/mod-dispositivos/mod-dispositivos.css">
    
    <style>
      .container-main {
      }
    </style>
  </head>

  <body>

    <div class="container-main">
      <!-- Header -->
      <header>
        <div class="title-wrapper f-start">
            <span>
                <button type="button" class="btn-atras mrgn-left" onclick="location.href='lista_usuarios.php'">Atrás</button>
            </span>
        </div>

        <div class="title-wrapper f-center">
            <span class="t-medium">
                Modificar Usuario
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
          <div class="add-card">
            <form autocomplete="off" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">

              <div class="field">
                <label class="label">Nombre</label>
                <div class="control">
                  <input class="input" type="text"name="nombre_usuario" placeholder="Nombre" value="<?=$nombreid?>">
                </div>
              </div>

              <div class="field">
                <label class="label">Apellido</label>
                <div class="control">
                  <input class="input" type="text" name="apellido_usuario" placeholder="Apellido" value="<?=$apellidoid?>">
                </div>
              </div>

              <div class="field">
                <label class="label">Nickname</label>
                <div class="control">
                  <input class="input" type="text" name="nickname_usuario" placeholder="Nickname" value="<?=$nicknameid?>">
                </div>
              </div>

              <div class="field">
                <label class="label">Contraseña</label>
                <div class="control">
                  <input class="input" type="text" name="contra_usuario" placeholder="Contraseña" value="<?=$contraid?>">
                </div>
              </div>

              <div class="field control-selector">
                <label class="label" style="margin: 0;">¿Dar permisos de admin?</label>
                <div class="control">
                  <div class="select">
                    <select name="is_admin">
                      <option value="<?=$value1?>"><?=$var1?></option>
                      <option value="<?=$value2?>"><?=$var2?></option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="f-center">
                <input class="btn-salir" type="submit" value="Modificar" name="add_device">
                <!-- 
                  <input class="btn-atras" type="submit" value="Eliminar Usuario" name="del_device">
                -->
              </div>

              <!-- Actual Values -->
              <input type="hidden" name="id_usuario" value="<?=$idUsuario?>">
              <input type="hidden" name="actual_nombre_usuario" value="<?=$nombreid?>">
              <input type="hidden" name="actual_apellido_usuario" value="<?=$apellidoid?>">
              <input type="hidden" name="actual_nickname_usuario" value="<?=$nicknameid?>">
              <input type="hidden" name="actual_contra_usuario" value="<?=$contraid?>">
              <select name="actual_is_admin" hidden>
                <option value="<?=$value1?>"><?=$var1?></option>
                <option value="<?=$value2?>"><?=$var2?></option>
              </select>
            </form>
          </div>
        </div>
      </main>
    </div>

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
            unset($_SESSION['actualID']);
        }
    ?>

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

