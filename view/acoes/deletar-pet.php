<?php

require_once(__DIR__ . "/../../controller/PetController.php");

if (!isset($_GET["idPet"])) {
  header("location: /adotai/view/pets-proprios.php");
} else {
  $petController = new PetController();
  $erro = $petController->deletarPetPorId($_GET["idPet"]);

  if ($erro) {
    echo "<h1>" . $erro . "</h1>";
  } else {
    header("location: /adotai/view/pets-proprios.php");
  }
}
