<?php

require_once(__DIR__ . "/constantes.php");

class Conexao
{
  private static $con = null;
  public static function getConexao()
  {
    if (self::$con == null) {
      try {
        $opcoes = array( //Define o charset da conexão
          //Define o tipo do erro como exceção 
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          //Define o tipo do retorno das consultas como array associativo
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );

        //Cria a conexão...
        self::$con = new PDO("mysql:host=" . DB_HOST . ";dbname=Adotai", DB_USER, DB_SENHA, $opcoes);
      } catch (PDOException $e) {
        echo "Erro ao conectar na base de dados.<br>";
        print_r($e);
      }
    }
    return self::$con;
  }
}
