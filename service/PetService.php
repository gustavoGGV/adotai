<?php

require_once(__DIR__ . "/../model/Pet.php");

class PetService
{
  public function validarPet(Pet $pet)
  {
    $invalidades = array();

    if (!$pet->getNomePet()) {
      array_push($invalidades, "Insira o nome do pet!");
    } else if (strlen($pet->getNomePet()) < 2 && strlen($pet->getNomePet()) > 80) {
      array_push($invalidades, "O nome do pet deve conter entre 2 e 80 caracteres!");
    }

    if (!$pet->getSexoPet()) {
      array_push($invalidades, "Selecione o sexo do pet!");
    }

    if (!$pet->getDescricaoPet()) {
      array_push($invalidades, "Insira uma descrição do pet!");
    }

    if ($pet->getTemRacaPet() === null) {
      array_push($invalidades, "Selecione se o pet tem raça ou não!");
    }

    if (!$pet->getEspecie()->getIdEsp()) {
      array_push($invalidades, "Selecione a espécie do pet!");
    }

    if (!$pet->getTemperamento()->getIdTem()) {
      array_push($invalidades, "Selecione o temperamento do pet!");
    }

    if (!$pet->getLinkImagemPet()) {
      array_push($invalidades, "Insira o endereço de uma imagem do pet!");
    }

    return $invalidades;
  }
}
