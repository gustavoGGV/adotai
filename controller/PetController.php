<?php

require_once(__DIR__ . "/../dao/PetDAO.php");
require_once(__DIR__ . "/../service/PetService.php");

class PetController
{
  private PetDAO $petDAO;
  private PetService $petService;

  public function __construct()
  {
    $this->petDAO = new PetDAO();
    $this->petService = new PetService();
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

  public function inserirPet(Pet $pet)
  {
    $invalidades = $this->petService->validarPet($pet);
    if ($invalidades) {
      return $invalidades;
    }

    $erro = $this->petDAO->inserirPet($pet);
    if ($erro) {
      array_push($invalidades, "Erro ao salvar o pet no banco de dados");
      if (AMBIENTE_DEV) {
        array_push($invalidades, $erro);
      }
    }

    return $invalidades;
  }

  public function alterarInformacoesPet(Pet $pet)
  {
    $invalidades = $this->petService->validarPet($pet);
    if ($invalidades) {
      return $invalidades;
    }

    $erro = $this->petDAO->alterarInformacoesPet($pet);
    if ($erro) {
      array_push($invalidades, "Erro ao alterar as informações do pet no banco de dados");
      if (AMBIENTE_DEV) {
        array_push($invalidades, $erro);
      }
    }

    return $invalidades;
  }

  public function buscarPetPorId(string $idPet)
  {
    $pet = $this->petDAO->buscarPetPorId($idPet);

    return $pet;
  }

  public function deletarPetPorId(string $idPet)
  {
    $erro = $this->petDAO->deletarPetPorId($idPet);

    return $erro;
  }
}
