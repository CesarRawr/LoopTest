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

  include_once('./public/php/connection.php');
  $database = new Connection();
  $db = $database->open();

  $tiposDispositivo = getTiposDispositivo($db);
  function getTiposDispositivo($db) {
    $_GRABAR_SQL = "SELECT * FROM tipo_dispositivo";   
    $data = $db->query( $_GRABAR_SQL);
    $hi = $data -> fetchAll();

    if($hi){
      return $hi;
    } else{
      return false;  
    }
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try{
        $id = $_POST["id"];    
        $cantidad = $_POST["cantidad"];   
        $observaciones = $_POST["observaciones"];   
        $postTipo = $_POST["tipo"];
        $onlyNombre = $_POST["nombre"];
        $nombre = $_POST["tipo"]." ".$_POST["nombre"]; 

        if ($postTipo === "Elige un tipo") {
          $_SESSION['message'] = "Seleccione un tipo"; 
        } else {
          $isRepeated = false;

          foreach($tiposDispositivo as $tippo) {
            if (strtolower($onlyNombre) === strtolower($tippo['nombre'])) {
              $isRepeated = true;
            }
          }

          if ($isRepeated) {
            $_SESSION['message'] = "El nombre del dispositivo no puede ser igual a alguno de los tipos de dispositivo"; 
          } else {
            if (trim($id) === "" || trim($nombre) === "" || trim($cantidad) === "") {
              $_SESSION['message'] = "No deje campos vacios"; 
            } else {
              $confirm = check($db, $id, $nombre);

              if (!$confirm['error']) {
                $_GRABAR_SQL = "INSERT INTO dispositivo VALUES ('{$id}','{$nombre}','{$cantidad}', 0, '{$observaciones}')";   
                $data = $db->query( $_GRABAR_SQL);  
                $hi = $data -> fetchAll();

                if(!$hi){
                  $_SESSION['message'] = "Dispositivo guardado con éxito";
                  $_SESSION['success'] = true;
                } else{
                  $_SESSION['message'] = "Error al guardar el dispositivo";   
                }
              } else {
                $_SESSION["message"] = $confirm['msg'];
              }
            }
          }
        }
    }
    catch(PDOException $e){
        $_SESSION['message'] = "Error al conectar con la base de datos";
    }

    //cerrar conexión
    $database->close();
}

  function check($db, $dataID, $dataNombre){
    $_GRABAR_SQL = "SELECT * FROM dispositivo WHERE id='$dataID'";
    $data = $db->query( $_GRABAR_SQL);
    $hi = $data -> fetchAll();

    if (sizeof($hi) === 0) {
      $_GRABAR_SQL = "SELECT * FROM dispositivo WHERE nombre='$dataNombre'";
      $data = $db->query( $_GRABAR_SQL);
      $hi = $data -> fetchAll();

      if (sizeof($hi) > 0) {
        return ["error" => true, "msg" => "Ya existe un dispositivo con ese nombre"];
      }
    } else {
      return ["error" => true, "msg" => "Ya existe un dispositivo con ese id"];
    }

    return ["error" => false];
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
  <link rel="stylesheet" type="text/css" href="public/css/lista-prestamos/header.css">
  <link rel="stylesheet" type="text/css" href="public/css/mod-dispositivos/mod-dispositivos.css">
  
  <style>
    .container-main {
      background-color: #c5dbf6;
    }

    .loans-container {
      display: flex;
      align-items: center;
      justify-content: space-around;
      flex-flow: row;
    }

    .btn-atras:hover {
      transition: all .3s ease-out 0s;
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
      <main>
        <!-- Loans Table -->
        <div class="loans-container scrollbar f-center">
          <div>
            <img width="250" src="images/azul.png" style="margin-bottom: 15vh;">
          </div>
          <div class="add-card">
            <form autocomplete="off" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">

              <div class="field">
                <label class="label">ID</label>
                <div class="control">
                  <input class="input" type="text" id="id" name="id" placeholder="ID">
                  <button style="width: 100%;background: #fafafa;color: #616161;border: 1px solid #e0e0e0; margin-top:5px" type="button" class="btn-atras">Generar ID</button>
                </div>
              </div>

              <div class="field">
                <label class="label">Nombre</label>
                <div class="control">
                  <div class="select is-normal" style="margin-bottom: 5px;">
                    <select name="tipo">
                      <option>Elige un tipo</option>
                      <?php 
                        foreach ($tiposDispositivo as $tipo) {
                          ?>
                            <option><?= $tipo['nombre'] ?></option>
                          <?php
                        }
                        ?>
                      ?>
                    </select>
                  </div>

                  <input class="input" type="text" id="nombre" name="nombre" placeholder="Nombre">
                </div>
              </div>

              <div class="field">
                <label class="label">Cantidad</label>
                <div class="control">
                  <input class="input" type="number" id ="cantidad" name="cantidad" min="0" max="100" placeholder="Cantidad" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null">
                </div>
              </div>

              <div class="field">
                <label class="label">Observaciones</label>
                <div class="control">
                  <input class="input" type="text" id="detalles" name="observaciones" placeholder="Detalles">
                </div>
              </div>

              <div class="f-center">
                <input style="background: #3781e0" class="btn-salir" type="submit" value="Agregar" name="add_device">
              </div>

            </form>
          </div>
          <div>
            <img width="250" src="images/azul.png" style="margin-bottom: 15vh;">
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
  <script type="text/javascript" src="public/js/idGenerator.js"></script>
</body>
</html>
