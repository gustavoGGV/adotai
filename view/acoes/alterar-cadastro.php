<?php

include_once(__DIR__ . "/adquirir-informacao-do-usuario.php");

$alteracoesUsuario = null;
// Desativada por padrão.
$alteracaoDeSenha = false;
$mensagensDeInvalidade = null;

if (!$usuario) {
  header("location: " . URL_BASE . "/view/pagina-principal.php");
}

if (isset($_POST["input-numero"])) {
  $nomeUsu = trim($_POST["input-nome"]) ? trim($_POST["input-nome"]) : null;
  $dataNascimentoUsu = trim($_POST["input-data-nasc"]) ? trim($_POST["input-data-nasc"]) : null;
  $cepUsu = trim($_POST["input-cep"]) ? trim($_POST["input-cep"]) : null;
  $complementoUsu = trim($_POST["input-complemento"]) ? trim($_POST["input-complemento"]) : null;

  // Apenas caso o usuário tenha preenchido o campo de senha nova.
  if (trim($_POST["input-senha-nova"])) {
    // Alteração de senha ativada.
    $alteracaoDeSenha = true;

    // Para o funcionamento da validação, não pode ser null.
    $inputSenhaAtualUsu = trim($_POST["input-senha-atual"]) ? trim($_POST["input-senha-atual"]) : "";

    $tamanhoSenhaNovaUsu = strlen(trim($_POST["input-senha-nova"]));
    $senhaNovaUsu = trim($_POST["input-senha-nova"]) ? password_hash(trim($_POST["input-senha-nova"]), PASSWORD_DEFAULT) : null;
    $confirmacaoSenhaNovaUsu = password_verify(trim($_POST["input-confirmacao-senha-nova"]), $senhaNovaUsu);
  }

  $telefoneUsu = trim($_POST["input-numero"]) ? trim($_POST["input-numero"]) : null;
  $tipoImagemPerfilUsu = !isset($_POST["input-imagem-gato"]) && isset($_POST["input-imagem-cachorro"]) ? "c" : "g";

  $usuarioController = new UsuarioController();

  if ($alteracaoDeSenha) {
    // Falso erro do Intelephense: ele acredita que $usuario só pode ser null, mas não é o caso da aplicação.
    $alteracoesUsuario = new Usuario($usuario->getIdUsu(), $nomeUsu, $telefoneUsu, $dataNascimentoUsu, $cepUsu, $complementoUsu, $senhaNovaUsu, $tamanhoSenhaNovaUsu, $confirmacaoSenhaNovaUsu, null, $tipoImagemPerfilUsu, false);
    $invalidades = $usuarioController->alterarInformacoesUsuario($alteracoesUsuario, true, $inputSenhaAtualUsu, $usuario->getSenhaUsu());
  } else {
    // Preenche somente os atributos que são necessários.
    $alteracoesUsuario = new Usuario($usuario->getIdUsu(), $nomeUsu, $telefoneUsu, $dataNascimentoUsu, $cepUsu, $complementoUsu, null, null, null, null, $tipoImagemPerfilUsu, false);
    // Passa strings vazinhas para as senhas, já que não serão consideradas para a validação.
    $invalidades = $usuarioController->alterarInformacoesUsuario($alteracoesUsuario, false, "", "");
  }

  if ($invalidades) {
    // Junta todas as mensagens de invalidade dentro de uma string separadas por <br>.
    $mensagensDeInvalidade = implode("<br>", $invalidades);
  } else {
    header("location: " . URL_BASE . "/view/pagina-principal.php");
  }
}
