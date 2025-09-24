<?php

require_once(__DIR__ . "/../dao/UsuarioDAO.php");
require_once(__DIR__ . "/../service/UsuarioService.php");

class UsuarioController
{
  private UsuarioDAO $usuarioDAO;
  private UsuarioService $usuarioService;

  public function __construct()
  {
    $this->usuarioDAO = new UsuarioDAO();
    $this->usuarioService = new UsuarioService();
  }

  public function inserirUsuario(Usuario $usuario)
  {
    $invalidades = $this->validarInformacoesUsuario($usuario, false, false, "", "");
    if ($invalidades) {
      return $invalidades;
    }

    $erro = $this->usuarioDAO->inserirUsuario($usuario);
    if ($erro === 2) {
      array_push($invalidades, "Já existe um usuário com este número de telefone!");
    } else if ($erro) {
      array_push($invalidades, "Erro ao salvar o usuário no banco de dados");
      if (AMBIENTE_DEV) {
        array_push($invalidades, $erro);
      }
    }

    return $invalidades;
  }

  public function alterarInformacoesUsuario(Usuario $usuario, bool $alteracaoDeSenha, string $inputSenhaAtual, string $hashSenhaAtual)
  {
    $invalidades = $this->validarInformacoesUsuario($usuario, true, $alteracaoDeSenha, $inputSenhaAtual, $hashSenhaAtual);
    if ($invalidades) {
      return $invalidades;
    }

    $erro = $this->usuarioDAO->alterarInformacoesUsuario($usuario, $alteracaoDeSenha);
    if ($erro) {
      array_push($invalidades, "Erro ao alterar as informações do usuário no banco de dados");
      if (AMBIENTE_DEV) {
        array_push($invalidades, $erro);
      }
    }

    return $invalidades;
  }

  public function validarInformacoesUsuario(Usuario $usuario, bool $alteracao, bool $alteracaoDeSenha, string $inputSenhaAtual, string $hashSenhaAtual)
  {
    $invalidades = $this->usuarioService->validarUsuario($usuario, $alteracao, $alteracaoDeSenha, $inputSenhaAtual, $hashSenhaAtual);

    return $invalidades;
  }

  public function encontrarUsuarioComTelefoneSenha(string $numero, string $senha)
  {
    $usuario = $this->usuarioDAO->encontrarUsuarioComTelefoneSenha($numero, $senha);

    return $usuario;
  }

  public function encontrarUsuarioPorId(string $id)
  {
    $usuario = $this->usuarioDAO->encontrarUsuarioPorId($id);

    return $usuario;
  }

  public function telefoneJaExiste(string $numero)
  {
    $jaExiste = $this->usuarioDAO->telefoneJaExiste($numero);

    return $jaExiste;
  }

  public function banirOuDesbanirUsuario(string $idUsu, bool $banir)
  {
    $erro = $this->usuarioDAO->banirOuDesbanirUsuario($idUsu, $banir);

    return $erro;
  }

  public function deletarUsuarioPorId(string $idUsu)
  {
    $erro = $this->usuarioDAO->deletarUsuarioPorId($idUsu);

    return $erro;
  }
}
