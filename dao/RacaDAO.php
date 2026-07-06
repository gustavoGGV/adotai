<?php

include_once __DIR__ . "/../util/Conexao.php";
include_once __DIR__ . "/../model/Raca.php";
include_once __DIR__ . "/../model/Especie.php";

class RacaDAO
{
    private PDO $conexao;

    public function __construct()
    {
        $this->conexao = Conexao::getConexao();
    }

    /**
     * Lista todas as raças de acordo com a espécie
     */
    public function listarRacasPorEspecie(int $idEspecie)
    {
        $sql = "SELECT r.idraca, r.nomeraca, e.idesp, e.nomeesp, e.porteesp
                FROM raca r
                JOIN especie e ON r.idesp = e.idesp
                WHERE e.idesp = ?
                ORDER BY r.nomeraca";

        $stm = $this->conexao->prepare($sql);
        $stm->execute([$idEspecie]);
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);

        return $this->mapearRacas($result);
    }

    private function mapearRacas(array $result)
    {
        $racas = [];

        foreach ($result as $reg) {
            $especie = new Especie(
                $reg["idesp"],
                $reg["nomeesp"],
                $reg["porteesp"],
            );

            $raca = new Raca($reg["idraca"], $reg["nomeraca"], $especie);
            array_push($racas, $raca);
        }

        return $racas;
    }
}
