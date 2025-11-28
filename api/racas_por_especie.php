<?php

require_once(__DIR__ . "/../controller/RacaController.php");

$idEspecie = isset($_GET['idEspecie']) ? (int)$_GET['idEspecie'] : 0;

$racaCont = new RacaController();
$racas = $racaCont->listarPorEspecie($idEspecie);

header('Content-Type: application/json; charset=utf-8');
echo json_encode($racas, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
