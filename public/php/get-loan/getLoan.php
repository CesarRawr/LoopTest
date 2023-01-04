<?php 
  header('Content-Type: application/json');
  $PROJECT_NAME = "/prestamos";
  $INC_DIR = $_SERVER["DOCUMENT_ROOT"] . $PROJECT_NAME ."/public/php/";
  require_once($INC_DIR.'connection.php');

  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
      $loan = json_decode(file_get_contents("php://input"));
      $database = new Connection();
      $db = $database->open();

      $query = "SELECT * FROM prestamo WHERE id={$loan->id_prestamo}";
      $data = $db->query($query);
      $loanData = $data->fetchAll()[0];

      // Obtener materia
      $nrc = $loanData['nrc_materia'];
      $query = "SELECT * FROM materia WHERE nrc='{$nrc}'";
      $data = $db->query($query);
      $materia = $data->fetchAll()[0];

      // Obtener aula
      $idAula = $loanData['id_aula'];
      $query = "SELECT * FROM aula WHERE id={$idAula}";
      $data = $db->query($query);
      $aula = $data->fetchAll()[0];

      // Obtener profesor
      $idProfesor = $loanData['id_profesor'];
      $query = "SELECT * FROM profesor WHERE noPersonal={$idProfesor}";
      $data = $db->query($query);
      $profesor = $data->fetchAll()[0];

      // Obtener alumno
      $idAlumno = $loanData['id_alumno'];
      if ($idAlumno !== null) {
        $query = "SELECT * FROM alumno WHERE matricula='{$idAlumno}'";
        $data = $db->query($query);
        $alumno = $data->fetchAll()[0];
      } else {
        $alumno = '';
      }

      // Dispositivos
      $idPrestamo = $loanData['id'];
      $query = "SELECT d.*, dp.prestado AS 'prestadoLocal', d.prestado AS 'prestadoGlobal' FROM dispositivo as d INNER JOIN dispositivo_prestado as dp ON d.id = dp.id_dispositivo WHERE dp.id_prestamo={$idPrestamo}";
      $data = $db->query($query);
      $dispositivos = $data->fetchAll();

      $response = [
        'success' => true, 
        'prestamo' => $loanData,
        'materia' => $materia,
        'aula' => $aula,
        'profesor' => $profesor,
        'alumno' => $alumno, 
        'dispositivos' => $dispositivos
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
