<?php

require_once(__DIR__ . "/../../controller/UsuarioController.php");

if (!isset($_GET["idUsu"])) {
  header("location: " . URL_BASE . "/view/pagina-principal.php");
} else {
  $usuarioController = new UsuarioController();
  $erro = $usuarioController->deletarUsuarioPorId($_GET["idUsu"]);

  if ($erro) {
    echo "<h1>Erro ao excluir o usuário.</h1>";

    if (AMBIENTE_DEV) {
      echo $erro;
    }
  } else {
    include_once(__DIR__ . "/deslogar.php");
  }
}
