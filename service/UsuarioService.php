<?php

require_once(__DIR__ . "/../model/Usuario.php");

class UsuarioService
{
  public function validarUsuario(Usuario $usuario, bool $alteracao, bool $alteracaoDeSenha, string $inputSenhaAtual, string $hashSenhaAtual)
  {
    $invalidades = array();

    if (!$usuario->getNomeUsu()) {
      array_push($invalidades, "Insira seu nome!");
      // Verificar tamanho do nome.
    } else if (strlen($usuario->getNomeUsu()) > 80) {
      array_push($invalidades, "Seu nome não deve passar de 80 caracteres!");
    }

    if (!$usuario->getDataNascimentoUsu()) {
      array_push($invalidades, "Insira sua data de nascimento!");
      /**
       * Este else if checará se a data de nascimento que usuário inseriu é mais velha do que 13 anos.
       * 
       * time() -> retorna o tempo atual (desde 01/01/1970) em Unix (em segundos);
       * strtotime() -> o primeiro parâmetro adiciona o tempo necessário, o segundo é o ponto de partida (transformado em Unix);
       *             L> caso o tempo de nascimendo do usuário + 13 anos seja mais recente (ou maior, como preferir), a data de nascimento é de alguém com menos de 13 anos.
       */
    } else if (time() < strtotime("+13 years", strtotime($usuario->getDataNascimentoUsu()))) {
      array_push($invalidades, "Você deve ter mais de 13 anos para criar uma conta Adotaí!");
    }

    if (!$usuario->getCepUsu()) {
      array_push($invalidades, "Insira seu CEP!");
    } else if (strlen($usuario->getCepUsu()) != 9) {
      array_push($invalidades, "Seu CEP deve conter 9 caracteres!");
    }

    if ($usuario->getComplementoUsu() && strlen($usuario->getComplementoUsu()) > 50) {
      array_push($invalidades, "O complemento de endereço não deve conter mais que 50 caracteres!");
    }

    if (!$usuario->getSenhaUsu() && !$alteracao) {
      array_push($invalidades, "Insira uma senha!");
    } else if ($usuario->getSenhaUsu() && !($usuario->getTamanhoSenhaUsu() > 8 && $usuario->getTamanhoSenhaUsu() < 30)) {
      array_push($invalidades, "Sua senha deve conter entre 8 e 30 caracteres!");
    } else if ($usuario->getSenhaUsu() && $usuario->getConfirmacaoSenhaUsu() === false) {
      array_push($invalidades, "A confirmação de senha deve ser igual a sua senha!");
    }

    if ($alteracaoDeSenha) {
      if (!password_verify($inputSenhaAtual, $hashSenhaAtual)) {
        array_push($invalidades, "A senha atual está errada!");
      } else if (password_verify($inputSenhaAtual, $usuario->getSenhaUsu())) {
        array_push($invalidades, "A senha nova digitada é a mesma senha atual!");
      }
    }

    if (!$usuario->getTelefoneUsu()) {
      array_push($invalidades, "Insira seu número de telefone!");
    } else if (strlen($usuario->getTelefoneUsu()) != 14 && strlen($usuario->getTelefoneUsu()) != 15) {
      array_push($invalidades, "Insira um número de telefone entre 14 e 15 caracteres!");
    }

    return $invalidades;
  }
}
