<?php

class Pet
{
  private ?int $idPet;
  private ?string $nomePet;
  private ?string $sexoPet;
  private ?string $descricaoPet;
  private ?Especie $especie;
  private ?Temperamento $temperamento;
  private ?string $linkImagemPet;
  private ?Usuario $acolhedor;
  private ?Raca $raca;
  private ?bool $temRaca;

  public function __construct($idPet, $nomePet, $sexoPet, $descricaoPet, $especie, $temperamento, $linkImagemPet, $acolhedor, $raca, $temRaca)
  {
    $this->idPet = $idPet;
    $this->nomePet = $nomePet;
    $this->sexoPet = $sexoPet;
    $this->descricaoPet = $descricaoPet;
    $this->especie = $especie;
    $this->temperamento = $temperamento;
    $this->linkImagemPet = $linkImagemPet;
    $this->acolhedor = $acolhedor;
    $this->raca = $raca;
    $this->temRaca = $temRaca;
  }

  public function getIdPet(): ?int
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

  public function getRaca(): ?Raca
  {
    return $this->raca;
  }

  public function getTemRaca(): ?bool
  {
    return $this->temRaca;
  }
}
