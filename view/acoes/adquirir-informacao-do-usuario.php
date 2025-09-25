<?php
require_once(__DIR__ . "/../../controller/UsuarioController.php");

$usuarioController = new UsuarioController();

$usuario = null;
if (isset($_COOKIE["idUsu"]) && isset($_COOKIE["telefoneUsu"])) {
  $usuario = $usuarioController->encontrarUsuarioPorIdEmHash($_COOKIE["idUsu"], $_COOKIE["telefoneUsu"]);

  if ($usuario instanceof PDOException) {
    echo "Erro de busca no banco de dados. Contate-nos: ajuda@adotai.com";
    if (AMBIENTE_DEV) {
      echo $usuario;
    }
  }
} else {
  return;
}
