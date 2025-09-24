<?php

require_once(__DIR__ . "/../model/Temperamento.php");
require_once(__DIR__ . "/../util/Conexao.php");

class TemperamentoDAO
{
  private PDO $conexao;

  public function __construct()
  {
    $this->conexao = Conexao::getConexao();
  }

  public function pegarTemperamentos()
  {
    try {
      $sql = "SELECT * FROM Temperamento";
      $stm = $this->conexao->prepare($sql);
      $stm->execute();
      $temperamentos = $stm->fetchAll();

      $temperamentosMapeados = null;
      if ($temperamentos) {
        $temperamentosMapeados = $this->mapearTemperamentos($temperamentos);
      }

      return $temperamentosMapeados;
    } catch (PDOException $e) {
      return $e;
    }
  }

  public function mapearTemperamentos(array $temperamentos)
  {
    $temperamentosMapeados = array();

    foreach ($temperamentos as $temperamento) {
      $temperamentoMapeado = new Temperamento($temperamento["idTem"], $temperamento["tipoTem"], $temperamento["energiaTem"]);

      array_push($temperamentosMapeados, $temperamentoMapeado);
    }

    return $temperamentosMapeados;
  }
}
