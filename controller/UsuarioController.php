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
    $this->usuarioService = new UsuarioService;
  }

  public function inserirUsuario(Usuario $usuario)
  {
    $invalidades = $this->usuarioService->validarUsuario($usuario);
    if ($invalidades) {
      return $invalidades;
    }

    $erroDoBanco = $this->usuarioDAO->inserirUsuario($usuario);
    if ($erroDoBanco) {
      array_push($invalidades, "Erro ao salvar o usuário no banco de dados");
      if (AMBIENTE_DEV) {
        array_push($invalidades, $erroDoBanco);
      }
    }

    return $invalidades;
  }
}
