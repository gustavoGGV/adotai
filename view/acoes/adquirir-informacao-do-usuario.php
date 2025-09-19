<?php
require_once(__DIR__ . "/../../controller/UsuarioController.php");

$usuarioController = new UsuarioController();

$usuario = array();
if ($_COOKIE["idUsu"]) {
  $usuario = $usuarioController->encontrarUsuarioPorId($_COOKIE["idUsu"]);

  if ($usuario instanceof PDOException) {
    echo "Erro de busca no banco de dados. Contate-nos: ajuda@adotai.com";
    if (AMBIENTE_DEV) {
      echo $usuario;
    }
  }
}
