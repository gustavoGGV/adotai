<?php

require_once __DIR__ . "/constantes.php";

class Conexao
{
    private static $con = null;

    public static function getConexao()
    {
        if (self::$con == null) {
            try {
                $opcoes = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ];

                self::$con = new PDO(
                    "pgsql:host=" .
                        DB_HOST .
                        ";port=" .
                        DB_PORT .
                        ";dbname=" .
                        DB_NAME,
                    DB_USER,
                    DB_SENHA,
                    $opcoes,
                );
            } catch (PDOException $e) {
                die("Erro ao conectar: " . $e->getMessage());
            }
        }

        return self::$con;
    }
}
