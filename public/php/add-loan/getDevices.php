<?php
  header('Content-Type: application/json');
  require_once('../lista-dispositivos/DispositivosController.php');

  $controller = new DispositivosController();
  $dispositivos = $controller->getDispositivosInfo();
  $controller->close();

  if (!$dispositivos) {
    $response = ['success' => false, 'error' => 'Algo salió mal'];
    echo json_encode($response);
    die;
  }

  $response = ['success' => true, 'devices' => $dispositivos];
  echo json_encode($response);
  die;
?>
