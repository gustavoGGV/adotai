<?php

require_once(__DIR__ . "/../../controller/UsuarioController.php");

if (!isset($_GET["idUsu"]) || !isset($_GET["banir"])) {
  header("location " . URL_BASE . "view/pagina-principal.php");
} else {
  $usuarioController = new UsuarioController();
  $erro = $usuarioController->banirOuDesbanirUsuario($_GET["idUsu"], intval($_GET["banir"]));

  if ($erro) {
    echo "<h1>Erro ao banir o usuário.</h1>";

    if (AMBIENTE_DEV) {
      echo $erro;
    }
  } else {
    header("location " . URL_BASE . "view/pagina-principal.php");
  }
}
