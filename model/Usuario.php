<?php

class Usuario
{
  private ?string $idUsu;
  private ?string $nomeUsu;
  private ?string $telefoneUsu;
  private ?string $dataNascimentoUsu;
  private ?string $cepUsu;
  private ?string $complementoUsu;
  private ?string $senhaUsu;
  private ?int $tamanhoSenhaUsu;
  private ?bool $confimacaoSenhaUsu;
  private ?string $tipoUsu;
  private ?string $tipoImagemPerfilUsu;

  public function __construct($idUsu, $nomeUsu, $telefoneUsu, $dataNascimentoUsu, $cepUsu, $complementoUsu, $senhaUsu, $tamanhoSenhaUsu, $confimacaoSenhaUsu, $tipoUsu, $tipoImagemPerfilUsu)
  {
    $this->idUsu = $idUsu;
    $this->nomeUsu = $nomeUsu;
    $this->telefoneUsu = $telefoneUsu;
    $this->dataNascimentoUsu = $dataNascimentoUsu;
    $this->cepUsu = $cepUsu;
    $this->complementoUsu = $complementoUsu;
    $this->senhaUsu = $senhaUsu;
    $this->tamanhoSenhaUsu = $tamanhoSenhaUsu;
    $this->confimacaoSenhaUsu = $confimacaoSenhaUsu;
    $this->tipoUsu = $tipoUsu;
    $this->tipoImagemPerfilUsu = $tipoImagemPerfilUsu;
  }

  public function getIdUsu(): ?string
  {
    return $this->idUsu;
  }

  public function getNomeUsu(): ?string
  {
    return $this->nomeUsu;
  }

  public function getTelefoneUsu(): ?string
  {
    return $this->telefoneUsu;
  }

  public function getDataNascimentoUsu(): ?string
  {
    return $this->dataNascimentoUsu;
  }

  public function getCepUsu(): ?string
  {
    return $this->cepUsu;
  }

  public function getComplementoUsu(): ?string
  {
    return $this->complementoUsu;
  }

  public function getSenhaUsu(): ?string
  {
    return $this->senhaUsu;
  }

  public function getTamanhoSenhaUsu(): ?int
  {
    return $this->tamanhoSenhaUsu;
  }

  public function getConfirmacaoSenhaUsu(): ?bool
  {
    return $this->confimacaoSenhaUsu;
  }

  public function getTipoUsu(): ?string
  {
    return $this->tipoUsu;
  }

  public function getTipoImagemPerfilUsu(): ?string
  {
    return $this->tipoImagemPerfilUsu;
  }
}
