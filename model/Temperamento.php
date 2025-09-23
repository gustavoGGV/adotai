<?php

class Temperamento
{
  private ?int $idTem;
  private ?string $tipoTem;
  private ?string $energiaTem;

  public function __construct($idTem, $tipoTem, $energiaTem)
  {
    $this->idTem = $idTem;
    $this->tipoTem = $tipoTem;
    $this->energiaTem = $energiaTem;
  }

  public function getIdTem(): ?int
  {
    return $this->idTem;
  }

  public function getTipoTem(): ?string
  {
    return $this->tipoTem;
  }

  public function getEnergiaTem(): ?string
  {
    return $this->energiaTem;
  }

  public function listarTemperamento()
  {
    $listagemTemperamento = $this->tipoTem;

    if ($this->energiaTem === "b") {
      $listagemTemperamento .= ", baixa energia";
    } else if ($this->energiaTem === "m") {
      $listagemTemperamento .= ", energia moderada";
    } else {
      $listagemTemperamento .= ", energético!";
    }

    return $listagemTemperamento;
  }
}
