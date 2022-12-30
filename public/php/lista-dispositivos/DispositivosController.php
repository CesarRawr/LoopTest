<?php
  $PROJECT_NAME = "/prestamos";
  $INC_DIR = $_SERVER["DOCUMENT_ROOT"] . $PROJECT_NAME ."/public/php/";
  require_once($INC_DIR.'connection.php');

  class DispositivosController {
    private $database = null;
    private $db = null;

    function __construct() {
      $this->database = new Connection();
      $this->db = $this->database->open();
    }

    public function getDispositivosInfo() {
      $sql = "SELECT * FROM dispositivo";
      $dispositivos = $this -> fetch($sql);

      return $dispositivos;
    }

    private function fetch($sql) {
      try {
        $data = $this->db->query($sql);
        return $data -> fetchAll();
      }
      catch(PDOException $e) {
        return false;
      }
    }

    public function close() {
      $this->database->close();
    }
  }