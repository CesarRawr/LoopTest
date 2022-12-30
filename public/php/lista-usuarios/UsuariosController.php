<?php
include_once('public/php/connection.php');



$database = new Connection();
$db = $database->open();

$consulta = "SELECT * from usuario";
$result = $db->prepare($consulta);
$result->execute();
//La variable $usuarios es la que lleva la información de los usuarios
$usuarios=$result->fetchAll(PDO::FETCH_ASSOC);



/*

class UsuariosController {
  private $database = null;
  private $db = null;

  function __construct() {
    $this->database = new Connection();
    $this->db = $this->database->open();
  }

  public function getUsersInfo() {
    $sql = "SELECT nombre, apellido, is_admin FROM usuario";
    $usuarios = $this -> fetch($sql);

    foreach($usuarios as $key => $usuario) {
      $sql = "
      SELECT nombre, apellido, is_admin
      FROM usuario
      ";
    }

  }


  private function fetch($sql) {
    try {
      $data = $this->db->query($sql);
      return $data -> fetchAll();
    }
    catch(PDOException $e) {
      return false;
    }


    public function close() {
      $this->database->close();
    }
  }
}

*/


?>
