<?php

require_once(__DIR__ . "/../dao/EspecieDAO.php");

class EspecieController
{
  private EspecieDAO $especieDAO;

  public function __construct()
  {
    $this->especieDAO = new EspecieDAO();
  }

  public function pegarEspecies()
  {
    $especies = $this->especieDAO->pegarEspecies();

    return $especies;
  }
}
