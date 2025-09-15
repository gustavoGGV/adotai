<?php

require_once(__DIR__ . "/../../controller/UsuarioController.php");

$numero = null;
$invalido = false;

if (isset($_POST["input-numero"])) {
  $usuarioController = new UsuarioController();
  $encontrou = $usuarioController->encontrarUsuario($_POST["input-numero"], $_POST["input-senha"]);

  if ($encontrou) {
    header("location: /adotai/view/pagina-principal.php");
  } else {
    $invalido = true;
  }
}
