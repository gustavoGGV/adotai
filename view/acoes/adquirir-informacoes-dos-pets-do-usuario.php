<?php

require_once __DIR__ . "/../../controller/PetController.php";

if (!isset($_COOKIE["idUsu"]) || !isset($_COOKIE["telefoneUsu"])) {
    header("location: " . URL_BASE . "/view/pagina-principal.php");

    exit();
}

$petController = new PetController();
$pets = $petController->buscarPetsPorIdDeUsuário($usuario->getIdUsu());

if ($pets instanceof PDOException) {
    echo "Erro de busca no banco de dados. Contate-nos: ajuda@adotai.com";
    if (AMBIENTE_DEV) {
        echo $pets;
    }
}
