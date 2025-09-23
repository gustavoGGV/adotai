<?php

class Pet
{
  private ?string $idPet;
  private ?string $nomePet;
  private ?string $sexoPet;
  private ?string $descricaoPet;
  private ?bool $temRacaPet;
  private ?string $linkImagemPet;
  private ?Especie $especie;
  private ?Temperamento $temperamento;

  public function __construct($idPet, $nomePet, $sexoPet, $descricaoPet, $temRacaPet, $linkImagemPet, $especie, $temperamento)
  {
    $this->idPet = $idPet;
    $this->nomePet = $nomePet;
    $this->sexoPet = $sexoPet;
    $this->descricaoPet = $descricaoPet;
    $this->temRacaPet = $temRacaPet;
    $this->linkImagemPet = $linkImagemPet;
    $this->especie = $especie;
    $this->temperamento = $temperamento;
  }

  public function getIdPet(): ?string
  {
    return $this->idPet;
  }

  public function getNomePet(): ?string
  {
    return $this->nomePet;
  }

  public function getSexoPet(): ?string
  {
    return $this->sexoPet;
  }

  public function getDescricaoPet(): ?string
  {
    return $this->descricaoPet;
  }

  public function getTemRacaPet(): ?bool
  {
    return $this->temRacaPet;
  }

  public function getLinkImagemPet(): ?string
  {
    return $this->linkImagemPet;
  }

  public function getEspecie(): ?Especie
  {
    return $this->especie;
  }

  public function getTemperamento(): ?Temperamento
  {
    return $this->temperamento;
  }
}
