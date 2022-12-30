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
    try{
      $id = $_POST["id_usuario"];
      
      $_GRABAR_SQL = "DELETE FROM usuario WHERE id={$id}";
      $data = $db->query( $_GRABAR_SQL);  
      $hi = $data -> fetchAll();

      if(!$hi){
        $_SESSION['message'] = "Usuario eliminado con éxito";
        $_SESSION['success'] = true;
      } else{
        $_SESSION['message'] = "Error al eliminar el usuario";
      }
    } catch(Exception $e){

      if (str_contains($e -> getMessage(), 'Integrity constraint violation')) {
        $_SESSION['message'] = "No se puede eliminar un usuario con préstamos hechos";
      } else {
        $_SESSION['message'] = "Error en el servidor";
      }
    }
  }

  include_once('public/php/lista-usuarios/UsuariosController.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Lista de usuarios</title>

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

  <style type="text/css">
    .container-main {
      /*85*/
      background-color: #daf6e4;
    }
  </style>
</head>
<body>
  <div class="container-main">
      <!-- Header -->
      <header>
        <div class="title-wrapper f-start">
            <span>
                <button style="background: #56d783" type="button" class="btn-atras mrgn-left" onclick="location.href='home.php'">Atrás</button>
            </span>
        </div>

        <div class="title-wrapper f-center">
            <span class="t-medium">
                Lista de usuarios
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
              <th style="width: 18%;">Nickname</th>
              <th style="width: 18%;">Nombre</th>
              <th style="width: 18%;">Apellido</th>
              <th style="width: 20%;">Rol</th>
              <th style="width: 18%;">Acciones</th>
            </tr>
            <?php 
              //Todo los valores pasan a través de $usuarios
              foreach ($usuarios as $usuario) { 
              ?>
              <tr>
                <td><?php echo $usuario['nickname']?></td>
                <td><?php echo $usuario['nombre']?></td>
                <td><?php echo $usuario['apellido']?></td>
                <?php
                $is_admin = $usuario['is_admin'];
                if($is_admin == 1){
                  ?>
                  <td><?php echo 'Administrador'?></td>
                  <?php
                }else{
                  ?>
                  <td><?php echo 'Usuario'?></td>
                  <?php
                }
                ?>
                <td>
                  <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
                    <input type="hidden" name="id_usuario" value="<?php echo $usuario['id']?>">

                    <button style="background: #6edd94" type="button" class="btn-atras mrgn-right" onclick="location.href='/prestamos/mod_usuarios.php?id=<?= $usuario['id'] ?>'">Editar</button>
                    <button type="submit" class="btn-salir">Borrar</button>
                  </form>
                </td>
              </tr>
              <?php
            }?>
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
