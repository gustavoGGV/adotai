<?php

require_once(__DIR__ . "/../dao/PetDAO.php");

class PetController
{
  private PetDAO $petDAO;

  public function __construct()
  {
    $this->petDAO = new PetDAO();
  }

  public function dadosDeTodosOsPets()
  {
    $pets = $this->petDAO->dadosDeTodosOsPets();

    return $pets;
  }

  public function buscarPetsPorIdDeUsuário(string $idUsu)
  {
    $petsEncontrados = $this->petDAO->buscarPetsPorIdDeUsuário($idUsu);

    return $petsEncontrados;
  }
}
