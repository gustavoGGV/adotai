<?php

require_once(__DIR__ . "/../model/Pet.php");
require_once(__DIR__ . "/../controller/PetController.php");

$nomePet = trim($_POST["nomePet"]) ? trim($_POST["nomePet"]) : null;
$sexoPet = trim($_POST["sexoPet"]) ? trim($_POST["sexoPet"]) : null;

$temRaca = $_POST["temRacaPet"] === "1" ? true : false;
if (!isset($_POST["temRacaPet"])) {
  $temRaca = null;
}

$idRaca = is_numeric($_POST["racaPet"]) ? intval(trim($_POST["racaPet"])) : null;
$raca = new Raca($idRaca, null, null);
$idEsp = is_numeric($_POST["especiePet"]) ? intval(trim($_POST["especiePet"])) : null;
$especie = new Especie($idEsp, null, null);
$idTem = is_numeric($_POST["temperamentoPet"]) ? intval(trim($_POST["temperamentoPet"])) : null;
$temperamento = new Temperamento($idTem, null, null);
$linkImagemPet = trim($_POST["linkImagemPet"]) ? trim($_POST["linkImagemPet"]) : null;
$descricaoPet = trim($_POST["descricaoPet"]) ? trim($_POST["descricaoPet"]) : null;
$idPet = is_numeric($_POST["idPet"]) ? intval(trim($_POST["idPet"])) : null;

$pet = new Pet($idPet, $nomePet, $sexoPet, $descricaoPet, $especie, $temperamento, $linkImagemPet, null, $raca, $temRaca);

$petController = new PetController();
$erros = $petController->alterarInformacoesPet($pet);

$msgErro = "";
if ($erros) {
  $msgErro = implode("<br>", $erros);
}

echo $msgErro;
