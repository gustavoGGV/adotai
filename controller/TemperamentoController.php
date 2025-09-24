<?php

require_once(__DIR__ . "/../dao/TemperamentoDAO.php");

class TemperamentoController
{
  private TemperamentoDAO $temperamentoDAO;

  public function __construct()
  {
    $this->temperamentoDAO = new TemperamentoDAO();
  }

  public function pegarTemperamentos()
  {
    $temperamentos = $this->temperamentoDAO->pegarTemperamentos();

    return $temperamentos;
  }
}
