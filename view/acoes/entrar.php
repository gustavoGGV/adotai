<?php

require_once(__DIR__ . "/../../controller/UsuarioController.php");

$numero = null;
$erro = null;

if (isset($_POST["input-numero"])) {
  $usuarioController = new UsuarioController();
  $encontrou = $usuarioController->encontrarUsuario($_POST["input-numero"], $_POST["input-senha"]);

  if ($encontrou === true) {
    header("location: /adotai/view/pagina-principal.php");
  } else if ($encontrou === false) {
    $erro = "O número de telefone e/ou a senha está incorreta!";
  } else {
    $erro = "Erro de busca no banco de dados. Contate-nos: ajuda@adotai.com";
    if (AMBIENTE_DEV) {
      $erro = $encontrou;
    }
  }
}
