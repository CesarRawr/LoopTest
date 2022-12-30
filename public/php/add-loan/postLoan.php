<?php 
  header('Content-Type: application/json');
  $PROJECT_NAME = "/prestamos";
  $INC_DIR = $_SERVER["DOCUMENT_ROOT"] . $PROJECT_NAME ."/public/php/";
  require_once($INC_DIR.'connection.php');

  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $loan = json_decode(file_get_contents("php://input"));
    $database = new Connection();
    $db = $database->open();

    $matricula = $loan -> id_alumno === "" ? "NULL": "'{$loan -> id_alumno}'";
    $query = "INSERT INTO prestamo (
        fecha,
        horario_entrada,
        horario_salida,
        is_active,
        id_usuario,
        id_profesor,
        id_aula,
        nrc_materia,
        id_alumno
      ) VALUES (
        '{$loan -> fecha}',
        '{$loan -> horario_entrada}',
        '{$loan -> horario_salida}',
        {$loan -> is_active},
        {$loan -> id_usuario},
        '{$loan -> id_profesor}',
        {$loan -> id_aula},
        '{$loan -> nrc_materia}',
        {$matricula}
      )";
    
    try {
      $db->query($query);
      $lastID = $db->query("SELECT LAST_INSERT_ID()");
      $lastID = $lastID -> fetchAll();
      $lastID = $lastID[0]['LAST_INSERT_ID()'];

      $devices = $loan -> dispositivos;

      // Quitar stock a dispositivos
      for ($i = 0; $i < count($devices); $i++) { 
        $prestado = $devices[$i]->prestado;

        $query = "SELECT prestado FROM dispositivo WHERE id='{$devices[$i]->id}'";
        $res = $db->query($query);
        $oldPrestado = $res -> fetchAll();

        // Añadir dispositivos asignados a prestamo
        $actualPrestado = $devices[$i]->prestado - $oldPrestado[0]['prestado'];
        $query = "
          INSERT INTO dispositivo_prestado 
          VALUES ({$lastID},'{$devices[$i]->id}', {$actualPrestado})";
        $db->query($query);

        // set prestado en dispositivo
        $query = "
          UPDATE dispositivo 
          SET prestado={$prestado} 
          WHERE id='{$devices[$i]->id}'";
        $db->query($query);
      }

      $response = ['success' => true];
      echo json_encode($response);
    }
    catch(PDOException $e) {
      echo json_encode($e);
    }
  }
?>
