<?php

require_once(__DIR__ . "/../../controller/PetController.php");

$petController = new PetController();
$pets = $petController->dadosDeTodosOsPets();

if ($pets instanceof PDOException) {
  echo "Erro de busca no banco de dados. Contate-nos: ajuda@adotai.com";
  if (AMBIENTE_DEV) {
    echo $pets;
  }
}
