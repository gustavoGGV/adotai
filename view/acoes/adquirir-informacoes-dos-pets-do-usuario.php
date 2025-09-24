<?php

require_once(__DIR__ . "/../../controller/PetController.php");

if (!isset($_GET["idUsu"])) {
  header("location: /adotai/view/pagina-principal.php");
}

$petController = new PetController();
$pets = $petController->buscarPetsPorIdDeUsuário($_GET["idUsu"]);

if ($pets instanceof PDOException) {
  echo "Erro de busca no banco de dados. Contate-nos: ajuda@adotai.com";
  if (AMBIENTE_DEV) {
    echo $pets;
  }
}
