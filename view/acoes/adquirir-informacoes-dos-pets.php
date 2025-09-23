<?php

require_once(__DIR__ . "/../../controller/PetController.php");

$petController = new PetController();
$pets = $petController->dadosDeTodosOsPets();

if ($pets instanceof PDOException) {
  echo $pets;

  return;
}
