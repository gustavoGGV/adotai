<?php

class Pet
{
  private ?string $idPet;
  private ?string $nomePet;
  private ?string $sexoPet;
  private ?string $descricaoPet;
  private ?bool $temRacaPet;
  private ?Especie $especie;
  private ?Temperamento $temperamento;
  private ?string $linkImagemPet;
  private ?Usuario $acolhedor;

  public function __construct($idPet, $nomePet, $sexoPet, $descricaoPet, $temRacaPet, $especie, $temperamento, $linkImagemPet, $acolhedor)
  {
    $this->idPet = $idPet;
    $this->nomePet = $nomePet;
    $this->sexoPet = $sexoPet;
    $this->descricaoPet = $descricaoPet;
    $this->temRacaPet = $temRacaPet;
    $this->especie = $especie;
    $this->temperamento = $temperamento;
    $this->linkImagemPet = $linkImagemPet;
    $this->acolhedor = $acolhedor;
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

  public function getEspecie(): ?Especie
  {
    return $this->especie;
  }

  public function getTemperamento(): ?Temperamento
  {
    return $this->temperamento;
  }

  public function getLinkImagemPet(): ?string
  {
    return $this->linkImagemPet;
  }

  public function getAcolhedor(): ?Usuario
  {
    return $this->acolhedor;
  }
}
