<?php

require_once(__DIR__ . "/../util/Conexao.php");

class UsuarioDAO
{
  private PDO $conexao;

  public function __construct()
  {
    $this->conexao = Conexao::getConexao();
  }

  public function inserirUsuario(Usuario $usuario)
  {
    try {
      $sql = "INSERT INTO Usuario (idUsu, nomeUsu, dataNascimentoUsu, cepUsu, complementoUsu, senhaUsu, telefoneUsu, tipoUsu) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
      $stm = $this->conexao->prepare($sql);
      $stm->execute([$usuario->getIdUsu(), $usuario->getNomeUsu(), $usuario->getDataNascimentoUsu(), $usuario->getCepUsu(), $usuario->getComplementoUsu(), $usuario->getSenhaUsu(), $usuario->getTelefoneUsu(), $usuario->getTipoUsu()]);

      return null;
    } catch (PDOException $e) {
      return $e;
    }
  }
}
