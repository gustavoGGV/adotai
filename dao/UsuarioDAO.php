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
    $telefoneJaExiste = $this->telefoneJaExiste($usuario->getTelefoneUsu());
    if ($telefoneJaExiste === true) {
      // Erro 2: telefone já existe no banco.
      return 2;
    }

    try {
      $sql = "INSERT INTO Usuario (idUsu, nomeUsu, dataNascimentoUsu, cepUsu, complementoUsu, senhaUsu, telefoneUsu, tipoUsu, tipoImagemPerfilUsu, banidoUsu) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
      $stm = $this->conexao->prepare($sql);
      $stm->execute([$usuario->getIdUsu(), $usuario->getNomeUsu(), $usuario->getDataNascimentoUsu(), $usuario->getCepUsu(), $usuario->getComplementoUsu(), $usuario->getSenhaUsu(), $usuario->getTelefoneUsu(), $usuario->getTipoUsu(), $usuario->getTipoImagemPerfilUsu(), 0]);

      // Sem erro.
      return null;
    } catch (PDOException $e) {
      // Erro 1: falha na inserção.
      return $e;
    }
  }

  public function alterarInformacoesUsuario(Usuario $usuario, bool $alteracaoDeSenha)
  {
    try {
      $sql = "UPDATE Usuario SET nomeUsu = ?, telefoneUsu = ?, dataNascimentoUsu = ?, cepUsu = ?, complementoUsu = ?, tipoImagemPerfilUsu = ?" . ($alteracaoDeSenha ? ", senhaUsu = ?" : "") . " WHERE idUsu = ?";
      $stm = $this->conexao->prepare($sql);
      if ($alteracaoDeSenha) {
        $stm->execute([$usuario->getNomeUsu(), $usuario->getTelefoneUsu(), $usuario->getDataNascimentoUsu(), $usuario->getCepUsu(), $usuario->getComplementoUsu(), $usuario->getTipoImagemPerfilUsu(), $usuario->getSenhaUsu(), $usuario->getIdUsu()]);
      } else {
        $stm->execute([$usuario->getNomeUsu(), $usuario->getTelefoneUsu(), $usuario->getDataNascimentoUsu(), $usuario->getCepUsu(), $usuario->getComplementoUsu(), $usuario->getTipoImagemPerfilUsu(), $usuario->getIdUsu()]);
      }

      return null;
    } catch (PDOException $e) {
      return $e;
    }
  }

  public function encontrarUsuarioComTelefoneSenha(string $numero, string $senha)
  {
    try {
      $sql = "SELECT * FROM Usuario WHERE telefoneUsu = ?";
      $stm = $this->conexao->prepare($sql);
      $stm->execute([$numero]);
      $usuario = $stm->fetchAll();

      if ($usuario) {
        $saoSenhasIguais = password_verify($senha, $usuario[0]["senhaUsu"]);
        if ($saoSenhasIguais) {
          $usuarioMapeado = $this->mapearUsuarios($usuario);

          return $usuarioMapeado[0];
        }
      }

      return false;
    } catch (PDOException $e) {
      return $e;
    }
  }

  public function encontrarUsuarioPorId(string $id)
  {
    try {
      $sql = "SELECT * FROM Usuario WHERE idUsu = ?";
      $stm = $this->conexao->prepare($sql);
      $stm->execute([$id]);
      $usuario = $stm->fetchAll();

      if (count($usuario) === 1) {
        $usuarioMapeado = $this->mapearUsuarios($usuario);

        return $usuarioMapeado[0];
      }

      return false;
    } catch (PDOException $e) {
      return $e;
    }
  }

  public function telefoneJaExiste(string $numero)
  {
    try {
      $sql = "SELECT * FROM Usuario WHERE telefoneUsu = ?";
      $stm = $this->conexao->prepare($sql);
      $stm->execute([$numero]);
      $usuarios = $stm->fetchAll();
    } catch (PDOException $e) {
      return $e;
    }

    if (count($usuarios) > 0) {
      return true;
    }

    return false;
  }

  public function banirOuDesbanirUsuario(string $idUsu, int $banir)
  {
    try {
      $sql = "UPDATE Usuario SET banidoUsu = ? WHERE idUsu = ?";
      $stm = $this->conexao->prepare($sql);
      $stm->execute([$banir, $idUsu]);

      return null;
    } catch (PDOException $e) {
      return $e;
    }
  }

  public function deletarUsuarioPorId(string $idUsu)
  {
    try {
      $sql = "DELETE FROM Usuario WHERE idUsu = ?";
      $stm = $this->conexao->prepare($sql);
      $stm->execute([$idUsu]);

      return null;
    } catch (PDOException $e) {
      return $e;
    }
  }

  private function mapearUsuarios(array $usuarios)
  {
    $usuariosMapeados = array();

    foreach ($usuarios as $usuario) {
      $usuarioMapeado = new Usuario($usuario["idUsu"], $usuario["nomeUsu"], $usuario["telefoneUsu"], $usuario["dataNascimentoUsu"], $usuario["cepUsu"], $usuario["complementoUsu"], $usuario["senhaUsu"], null, null, $usuario["tipoUsu"], $usuario["tipoImagemPerfilUsu"], $usuario["banidoUsu"]);

      array_push($usuariosMapeados, $usuarioMapeado);
    }

    return $usuariosMapeados;
  }
}
