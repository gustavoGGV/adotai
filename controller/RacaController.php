<?php

include_once(__DIR__ . "/../dao/RacaDAO.php");

class RacaController {

    private RacaDAO $dao;

    public function __construct() {
        $this->dao = new RacaDAO();
    }

    public function listarPorEspecie(int $idEspecie): array {
        return $this->dao->listarRacasPorEspecie($idEspecie);
    }
}
