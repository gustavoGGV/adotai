<?php

include_once(__DIR__ . "/../util/Conexao.php");
include_once(__DIR__ . "/../model/Raca.php");
include_once(__DIR__ . "/../model/Especie.php");

class RacaDAO {

    private PDO $conexao;

    public function __construct() {
        $this->conexao = Conexao::getConexao();
    }

    /**
     * Lista todas as raças de acordo com a espécie
     */
    public function listarRacasPorEspecie(int $idEspecie) {
        $sql = "SELECT r.idRaca, r.nomeRaca, e.idEsp, e.nomeEsp, e.porteEsp 
                FROM Raca r
                JOIN Especie e ON r.idEsp = e.idEsp
                WHERE e.idEsp = ?
                ORDER BY r.nomeRaca";

        $stm = $this->conexao->prepare($sql);
        $stm->execute([$idEspecie]);
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);

        return $this->mapearRacas($result);
    }

    private function mapearRacas(array $result) {
        $racas = array();

        foreach ($result as $reg) {
            $especie = new Especie(
                $reg['idEsp'],
                $reg['nomeEsp'],
                $reg['porteEsp']
            );

            $raca = new Raca($reg['idRaca'], $reg['nomeRaca'], $especie);
            array_push($racas, $raca);
        }

        return $racas;
    }
}
