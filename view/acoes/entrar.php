<?php

require_once(__DIR__ . "/../../controller/UsuarioController.php");
require_once(__DIR__ . "/../../model/Usuario.php");

$numero = null;
$erro = null;

if (isset($_POST["input-numero"])) {
  $numero = $_POST["input-numero"];

  $usuarioController = new UsuarioController();
  $usuario = $usuarioController->encontrarUsuarioComTelefoneSenha($_POST["input-numero"], $_POST["input-senha"]);

  // Caso retorne um erro do banco.
  if ($usuario instanceof PDOException) {
    $erro = "Erro de busca no banco de dados. Contate-nos: ajuda@adotai.com";
    if (AMBIENTE_DEV) {
      $erro = $usuario;
    }
  } else if (!$usuario) {
    $erro = "O número de telefone e/ou a senha está incorreta!";
  } else if ($usuario->getBanidoUsu()) {
    $erro = "Esta conta está banida do Adotaí";
  } else {
    // Cookie com o ID do usuário (em hash) que entrou na sessão. Expira em 120 dias.
    setcookie("idUsu", password_hash($usuario->getIdUsu(), PASSWORD_DEFAULT), time() + 60 * 60 * 24 * 120, "/", "", false, true);
    setcookie("telefoneUsu", $usuario->getTelefoneUsu(), time() + 60 * 60 * 24 * 120, "/", "", false, true);

    header("location " . URL_BASE . "view/pagina-principal.php");
  }
}
