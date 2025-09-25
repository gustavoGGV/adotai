<?php

require_once(__DIR__ . "/../../util/Conexao.php");
require_once(__DIR__ . "/../../model/Pet.php");
require_once(__DIR__ . "/../../model/Especie.php");
require_once(__DIR__ . "/../../model/Temperamento.php");
require_once(__DIR__ . "/../../model/Usuario.php");
require_once(__DIR__ . "/../../controller/PetController.php");

$cadastro = null;
$mensagensDeInvalidade = null;
$petController = new PetController();

if (isset($_GET["idPet"])) {
  $cadastro = $petController->buscarPetPorId($_GET["idPet"]);

  if ($cadastro instanceof PDOException) {
    echo "<h2>Erro na alteração do pet no banco.</h2>";

    return;
  }
}

if (isset($_POST["input-nome-pet"])) {
  $nomePet = trim($_POST["input-nome-pet"]) ? trim($_POST["input-nome-pet"]) : null;
  $sexoPet = trim($_POST["select-sexo-pet"]) ? trim($_POST["select-sexo-pet"]) : null;
  $temRacaPet = isset($_POST["select-raca-pet"]) ? intval(trim($_POST["select-raca-pet"])) : null;

  if ($temRacaPet) {
    if ($temRacaPet === 1) {
      $temRacaPet = true;
    } else {
      $temRacaPet = false;
    }
  }

  $idEsp = trim($_POST["select-especie-pet"]) ? trim($_POST["select-especie-pet"]) : null;
  $especie = new Especie($idEsp, null, null);

  $idTem = trim($_POST["select-temperamento-pet"]) ? trim($_POST["select-temperamento-pet"]) : null;
  $temperamento = new Temperamento($idTem, null, null);

  $linkImagemPet = trim($_POST["input-imagem-pet"]) ? trim($_POST["input-imagem-pet"]) : null;
  $descricaoPet = trim($_POST["input-descricao-pet"]) ? trim($_POST["input-descricao-pet"]) : null;

  if (!isset($_GET["idPet"])) {
    include_once(__DIR__ . "/adquirir-informacao-do-usuario.php");

    if (!$usuario) {
      header("location: /adotai/view/pagina-principal.php");
    }

    $acolhedor = new Usuario($usuario->getIdUsu(), $usuario->getNomeUsu(), null, null, null, null, null, null, null, null, null, null);
    $cadastro = new Pet(null, $nomePet, $sexoPet, $descricaoPet, $temRacaPet, $especie, $temperamento, $linkImagemPet, $acolhedor);
  } else {
    $cadastro = new Pet($_GET["idPet"], $nomePet, $sexoPet, $descricaoPet, $temRacaPet, $especie, $temperamento, $linkImagemPet, null);
  }

  $invalidades = null;
  if (!isset($_GET["idPet"])) {
    $invalidades = $petController->inserirPet($cadastro);
  } else {
    $invalidades = $petController->alterarInformacoesPet($cadastro);
  }

  if ($invalidades) {
    $mensagensDeInvalidade = implode("<br>", $invalidades);
  } else {
    header("location: /adotai/view/pets-proprios.php");
  }
}
