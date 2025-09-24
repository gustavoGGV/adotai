<?php

require_once(__DIR__ . "/../../util/Conexao.php");
require_once(__DIR__ . "/../../model/Pet.php");
require_once(__DIR__ . "/../../model/Especie.php");
require_once(__DIR__ . "/../../model/Temperamento.php");
require_once(__DIR__ . "/../../model/Usuario.php");
require_once(__DIR__ . "/../../controller/PetController.php");

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

if (isset($_POST["input-nome-pet"])) {
  $nomePet = trim($_POST["input-nome-pet"]) ? trim($_POST["input-nome-pet"]) : null;
  $sexoPet = trim($_POST["select-sexo-pet"]) ? trim($_POST["select-sexo-pet"]) : null;
  $temRacaPet = trim($_POST["select-raca-pet"]) ? intval(trim($_POST["select-raca-pet"])) : null;

  $idEsp = trim($_POST["select-especie-pet"]) ? trim($_POST["select-especie-pet"]) : null;
  $especie = new Especie($idEsp, null, null);

  $idTem = trim($_POST["select-temperamento-pet"]) ? trim($_POST["select-temperamento-pet"]) : null;
  $temperamento = new Temperamento($idTem, null, null);

  $linkImagemPet = trim($_POST["input-imagem-pet"]) ? trim($_POST["input-imagem-pet"]) : null;
  $descricaoPet = trim($_POST["input-descricao-pet"]) ? trim($_POST["input-descricao-pet"]) : null;

  include_once(__DIR__ . "/adquirir-informacao-do-usuario.php");

  if (!$usuario) {
    header("location: /adotai/view/pagina-principal.php");
  }

  $acolhedor = new Usuario($usuario->getIdUsu(), $usuario->getNomeUsu(), null, null, null, null, null, null, null, null, null, null);

  $cadastro = new Pet(guidv4(), $nomePet, $sexoPet, $descricaoPet, intval($temRacaPet) === 1 ? true : false, $especie, $temperamento, $linkImagemPet, $acolhedor);

  $petController = new PetController();
  $invalidades = $petController->inserirPet($cadastro);

  if ($invalidades) {
    $mensagensDeInvalidade = implode("<br>", $invalidades);
  } else {
    header("location: /adotai/view/pets-proprios.php");
  }
}
