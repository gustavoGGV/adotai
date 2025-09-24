<?php

require_once(__DIR__ . "/../model/Especie.php");
require_once(__DIR__ . "/../util/Conexao.php");

class EspecieDAO
{
  private PDO $conexao;

  public function __construct()
  {
    $this->conexao = Conexao::getConexao();
  }

  public function pegarEspecies()
  {
    try {
      $sql = "SELECT * FROM Especie";
      $stm = $this->conexao->prepare($sql);
      $stm->execute();
      $especies = $stm->fetchAll();

      $especiesMapeadas = null;
      if ($especies) {
        $especiesMapeadas = $this->mapearEspecies($especies);
      }

      return $especiesMapeadas;
    } catch (PDOException $e) {
      return $e;
    }
  }

  public function mapearEspecies(array $especies)
  {
    $especiesMapeadas = array();

    foreach ($especies as $especie) {
      $especieMapeada = new Especie($especie["idEsp"], $especie["nomeEsp"], $especie["porteEsp"]);

      array_push($especiesMapeadas, $especieMapeada);
    }

    return $especiesMapeadas;
  }
}
