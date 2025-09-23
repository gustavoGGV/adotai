<?php

require_once(__DIR__ . "/../../controller/UsuarioController.php");

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
  } else if ($usuario) {
    // Cookie com o ID do usuário que entrou na sessão. Expira em 120 dias.
    setcookie("idUsu", $usuario->getIdUsu(), time() + 60 * 60 * 24 * 120, "/", "", false, true);

    header("location: /adotai/view/pagina-principal.php");
  } else {
    $erro = "O número de telefone e/ou a senha está incorreta!";
  }
}
