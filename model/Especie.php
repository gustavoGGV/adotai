<?php

class Especie
{
  private ?int $idEsp;
  private ?string $nomeEsp;
  private ?string $porteEsp;

  public function __construct($idEsp, $nomeEsp, $porteEsp)
  {
    $this->idEsp = $idEsp;
    $this->nomeEsp = $nomeEsp;
    $this->porteEsp = $porteEsp;
  }

  public function getIdEsp(): ?int
  {
    return $this->idEsp;
  }

  public function getNomeEsp(): ?string
  {
    return $this->nomeEsp;
  }

  public function getPorteEsp(): ?string
  {
    return $this->porteEsp;
  }

  public function listarEspecie()
  {
    $listagemEspecie = $this->nomeEsp;

    if ($this->porteEsp === "p") {
      $listagemEspecie .= ", pequeno porte";
    } else if ($this->porteEsp === "m") {
      $listagemEspecie .= ", médio porte";
    } else {
      $listagemEspecie .= ", grande porte";
    }

    return $listagemEspecie;
  }
}
