<?php 
  header('Content-Type: application/json');
  $PROJECT_NAME = "/prestamos";
  $INC_DIR = $_SERVER["DOCUMENT_ROOT"] . $PROJECT_NAME ."/public/php/";
  require_once($INC_DIR.'connection.php');

  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
      $loan = json_decode(file_get_contents("php://input"));

      // Si hay dispositivos eliminados
      if (sizeof($loan->deletedDevices) > 0){
        array_map(function($deletedDevice) {
          $database = new Connection();
          $db = $database->open();

          // Eliminar dispositivo de la tabla dispositivo_prestado
          $query = "DELETE FROM dispositivo_prestado WHERE id_prestamo={$deletedDevice->loanID} AND id_dispositivo='{$deletedDevice->id}'";
          $db->query($query);

          // Quitarle préstamo al dispositivo en la tabla dispositivo
          $query = "UPDATE dispositivo SET prestado=prestado-{$deletedDevice->devuelto} WHERE id='{$deletedDevice->id}'";
          $db->query($query);

          $database->close();          
        }, $loan->deletedDevices);
      }

      // Realizar operaciones a los dispositivos modificados
      if (sizeof($loan->devices) > 0) {
        array_map(function($device){
          $database = new Connection();
          $db = $database->open();
    
          // Si el dispositivo no es nuevo y tiene algún cambio
          if (!$device->isNew && !str_contains($device->operacion, 'idle')) {
            $types = ['suma' => '+', 'resta' => '-'];
            $operation = $types[$device->operacion];

            // Actualizar el dispositivo en la tabla dispositivo
            $query = "UPDATE dispositivo SET prestado=prestado{$operation}{$device->diff} WHERE id='{$device->id}'";
            $db->query($query);

            // Actualizar el dispositivo en la tabla dispositivo_prestado
            $query = "UPDATE dispositivo_prestado SET prestado=prestado{$operation}{$device->diff} WHERE id_prestamo={$device->loanID} AND id_dispositivo='{$device->id}'";
            $db->query($query);
          }

          // Si el dispositivo es nuevo
          if ($device->isNew) {
            // Agregar a la tabla dispositivo_prestado
            $query = "INSERT INTO dispositivo_prestado 
            VALUES ({$device->loanID},'{$device->id}', {$device->diff})";
            $db->query($query);

            // Sumar a la tabla dispositivo
            $query = "UPDATE dispositivo SET prestado=prestado+{$device->diff} WHERE id='{$device->id}'";
            $db->query($query);
          }

          $database->close(); 
        }, $loan->devices);
      }

      $response = [
        'success' => true,
        'msg' => 'Se han actualizado con exito los dispositivos en el prestamo'
      ];

      echo json_encode($response);
    }
    catch(PDOException $e) {
      $response = [
        'success' => false, 
        'msg'  => $e
      ];

      echo json_encode($response);
    }
  }
?>
