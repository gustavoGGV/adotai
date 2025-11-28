<?php

require_once(__DIR__ . "/../../util/Conexao.php");
require_once(__DIR__ . "/../../model/Usuario.php");
require_once(__DIR__ . "/../../controller/UsuarioController.php");

$cadastro = null;
$mensagensDeInvalidade = null;

if (isset($_POST["input-numero"])) {
  $nomeUsu = trim($_POST["input-nome"]) ? trim($_POST["input-nome"]) : null;
  $dataNascimentoUsu = trim($_POST["input-data-nasc"]) ? trim($_POST["input-data-nasc"]) : null;
  $cepUsu = trim($_POST["input-cep"]) ? trim($_POST["input-cep"]) : null;
  $complementoUsu = trim($_POST["input-complemento"]) ? trim($_POST["input-complemento"]) : null;

  // Pega a tamanho da senha, encripta ela em formato hash e depois a compara com a confirmação de senha.
  $tamanhoSenhaUsu = strlen(trim($_POST["input-senha"]));
  $senhaUsu = trim($_POST["input-senha"]) ? password_hash(trim($_POST["input-senha"]), PASSWORD_DEFAULT) : null;
  $confirmacaoSenhaUsu = trim($_POST["input-confirmar-senha"]) ? password_verify(trim($_POST["input-confirmar-senha"]), $senhaUsu) : false;

  $telefoneUsu = trim($_POST["input-numero"]) ? trim($_POST["input-numero"]) : null;

  $cadastro = new Usuario(null, $nomeUsu, $telefoneUsu, $dataNascimentoUsu, $cepUsu, $complementoUsu, $senhaUsu, $tamanhoSenhaUsu, $confirmacaoSenhaUsu, "c", "c", false);

  $usuarioController = new UsuarioController();
  $invalidades = $usuarioController->inserirUsuario($cadastro);

  if ($invalidades) {
    // Junta todas as mensagens de invalidade dentro de uma string separadas por <br>.
    $mensagensDeInvalidade = implode("<br>", $invalidades);
  } else {
    header("location " . URL_BASE . "view/login.php");
  }
}
