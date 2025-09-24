<?php

require_once(__DIR__ . "/../../util/Conexao.php");
require_once(__DIR__ . "/../../model/Usuario.php");
require_once(__DIR__ . "/../../controller/UsuarioController.php");

// Função que cria UUID's aleatórias.
function guidv4()
{
  // Checa se essa função "com_create_guid" existe (ela é presente no Windows por padrão); caso ela exista, é gerada uma UUID envolta de chaves e é retornada tirando as chaves por trim.
  if (function_exists('com_create_guid') === true) {
    return trim(com_create_guid(), '{}');
  }

  // Código que achei na internet para gerar UUID's. Crédito: https://www.php.net/manual/en/function.com-create-guid.php, usuário "pavel.volyntsev(at)gmail".
  $data = openssl_random_pseudo_bytes(16);
  $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
  $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
  return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

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
  $confirmacaoSenhaUsu = password_verify(trim($_POST["input-confirmar-senha"]), $senhaUsu);

  $telefoneUsu = trim($_POST["input-numero"]) ? trim($_POST["input-numero"]) : null;

  $cadastro = new Usuario(guidv4(), $nomeUsu, $telefoneUsu, $dataNascimentoUsu, $cepUsu, $complementoUsu, $senhaUsu, $tamanhoSenhaUsu, $confirmacaoSenhaUsu, "c", "c", false);

  $usuarioController = new UsuarioController();
  $invalidades = $usuarioController->inserirUsuario($cadastro);

  if ($invalidades) {
    // Junta todas as mensagens de invalidade dentro de uma string separadas por <br>.
    $mensagensDeInvalidade = implode("<br>", $invalidades);
  } else {
    header("location: /adotai/view/login.php");
  }
}
