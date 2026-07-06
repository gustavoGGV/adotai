<?php

require_once __DIR__ . "/../util/Conexao.php";

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
            $sql =
                "INSERT INTO usuario (idusu, nomeusu, datanascimentousu, cepusu, complementousu, senhausu, telefoneusu, tipousu, tipoimagemperfilusu, banidousu) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stm = $this->conexao->prepare($sql);
            $stm->execute([
                $usuario->getIdUsu(),
                $usuario->getNomeUsu(),
                $usuario->getDataNascimentoUsu(),
                $usuario->getCepUsu(),
                $usuario->getComplementoUsu(),
                $usuario->getSenhaUsu(),
                $usuario->getTelefoneUsu(),
                $usuario->getTipoUsu(),
                $usuario->getTipoImagemPerfilUsu(),
                0,
            ]);

            // Sem erro.
            return null;
        } catch (PDOException $e) {
            // Erro 1: falha na inserção.
            return $e;
        }
    }

    public function alterarInformacoesUsuario(
        Usuario $usuario,
        bool $alteracaoDeSenha,
    ) {
        try {
            $sql =
                "UPDATE usuario SET nomeusu = ?, telefoneusu = ?, datanascimentousu = ?, cepusu = ?, complementousu = ?, tipoimagemperfilusu = ?" .
                ($alteracaoDeSenha ? ", senhausu = ?" : "") .
                " WHERE idusu = ?";
            $stm = $this->conexao->prepare($sql);
            if ($alteracaoDeSenha) {
                $stm->execute([
                    $usuario->getNomeUsu(),
                    $usuario->getTelefoneUsu(),
                    $usuario->getDataNascimentoUsu(),
                    $usuario->getCepUsu(),
                    $usuario->getComplementoUsu(),
                    $usuario->getTipoImagemPerfilUsu(),
                    $usuario->getSenhaUsu(),
                    $usuario->getIdUsu(),
                ]);
            } else {
                $stm->execute([
                    $usuario->getNomeUsu(),
                    $usuario->getTelefoneUsu(),
                    $usuario->getDataNascimentoUsu(),
                    $usuario->getCepUsu(),
                    $usuario->getComplementoUsu(),
                    $usuario->getTipoImagemPerfilUsu(),
                    $usuario->getIdUsu(),
                ]);
            }

            return null;
        } catch (PDOException $e) {
            return $e;
        }
    }

    public function encontrarUsuarioComTelefoneSenha(
        string $numero,
        string $senha,
    ) {
        try {
            $sql = "SELECT * FROM usuario WHERE telefoneusu = ?";
            $stm = $this->conexao->prepare($sql);
            $stm->execute([$numero]);
            $usuario = $stm->fetchAll();

            if ($usuario) {
                $saoSenhasIguais = password_verify(
                    $senha,
                    $usuario[0]["senhausu"],
                );
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
            $sql = "SELECT * FROM usuario WHERE idusu = ?";
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
            $sql = "SELECT * FROM usuario WHERE telefoneusu = ?";
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
            $sql = "UPDATE usuario SET banidousu = ? WHERE idusu = ?";
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
            // Como os pets possuem a relação com a conta do usuário, também é necessário deletá-los.
            $sql =
                "DELETE FROM pet WHERE idusu = ?; DELETE FROM usuario WHERE idusu = ?";
            $stm = $this->conexao->prepare($sql);
            $stm->execute([$idUsu, $idUsu]);

            return null;
        } catch (PDOException $e) {
            return $e;
        }
    }

    public function dadosDeTodosOsUsuarios()
    {
        try {
            $sql = "SELECT * FROM usuario";
            $stm = $this->conexao->prepare($sql);
            $stm->execute();
            $usuarios = $stm->fetchAll();

            $usuariosMapeados = null;
            if ($usuarios) {
                $usuariosMapeados = $this->mapearUsuarios($usuarios);
            }

            return $usuariosMapeados;
        } catch (PDOException $e) {
            return $e;
        }
    }

    public function encontrarUsuarioPorIdEmHash(
        string $hashId,
        string $telefoneUsu,
    ) {
        try {
            $sql = "SELECT * FROM usuario WHERE telefoneusu = ?";
            $stm = $this->conexao->prepare($sql);
            $stm->execute([$telefoneUsu]);
            $usuario = $stm->fetch();

            if ($usuario) {
                $usuarioMapeado = $this->mapearUsuarios($usuario);

                if (password_verify($usuarioMapeado[0]->getIdUsu(), $hashId)) {
                    return $usuarioMapeado[0];
                }
            }

            return null;
        } catch (PDOException $e) {
            return $e;
        }
    }

    private function mapearUsuarios(array $usuarios)
    {
        $usuariosMapeados = [];

        foreach ($usuarios as $usuario) {
            $usuarioMapeado = new Usuario(
                $usuario["idusu"],
                $usuario["nomeusu"],
                $usuario["telefoneusu"],
                $usuario["datanascimentousu"],
                $usuario["cepusu"],
                $usuario["complementousu"],
                $usuario["senhausu"],
                null,
                null,
                $usuario["tipousu"],
                $usuario["tipoimagemperfilusu"],
                $usuario["banidousu"],
            );

            array_push($usuariosMapeados, $usuarioMapeado);
        }

        return $usuariosMapeados;
    }
}
