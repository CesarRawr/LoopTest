<?php
include_once('public/php/connection.php');

class ModDispositivoController {
	private $database = null;
	private $db = null;

	function __construct() {
		$this->database = new Connection();
		$this->db = $this->database->open();
	}

	public function getDispositivoInfo($id) {
		try{
			$sql = "SELECT * FROM dispositivo WHERE id='$id'";
      $dispositivo = $this -> fetch($sql);
      return $dispositivo;
		} catch(PDOException $e){
			return false;
		}
	}

	public function setDispositivoInfo($nombre, $cantidad, $comentarios, $id) {
		try{
			$sql = "
				UPDATE dispositivo 
				SET nombre='$nombre', cantidad={$cantidad}, observaciones='$comentarios' 
				WHERE id='$id'
			";

			$this->fetch($sql);
			return true;
		} catch(PDOException $e) {
			return false;
		}
	}

	public function delDispositivo ($id) {
		try{
			$sql = "DELETE FROM dispositivo WHERE id='$id'";

			$this->fetch($sql);
			return ["success" => true, "msg" => "Dispositivo eliminado con éxito"];
		} catch(PDOException $e) {
			if (str_contains($e -> getMessage(), 'Integrity constraint violation')) {
        return ["success" => false, "msg" => "No se puede eliminar un dispositivo si hay préstamos asignados al mismo"];
      } else {
      	return ["success" => false, "msg" => "Error en el servidor al intentar eliminar el dispositivo"];
      }
		}	
	}

  private function fetch($sql) {
    try {
      $data = $this->db->query($sql);
      return $data -> fetchAll();
    }
    catch(PDOException $e){
      throw new PDOException($e -> getMessage());
    }
  }

  public function existNombre($nombre, $id) {
		try{
			$sql = "SELECT * FROM dispositivo WHERE nombre='$nombre' AND id!='$id'";
	    $dispositivo = $this -> fetch($sql);

	    if (sizeof($dispositivo) > 0) {
	    	return ["exist" => true, "msg" => "El nombre que intentó usar, ya se encuentra ocupado"];
	    } else {
	    	return ["exist" => false, "msg" => "Algo salió mal al intentar modificar el dispositivo"];
	    }
		} catch(PDOException $e){
			return ["exist" => true, "msg" => "Algo salió mal al intentar modificar el dispositivo"];;
		}
	}
}

?>