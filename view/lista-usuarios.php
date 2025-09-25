<?php

require_once(__DIR__ . "/../controller/UsuarioController.php");

$usuarioController = new UsuarioController();
$usuarios = $usuarioController->dadosDeTodosOsUsuarios();

if ($usuarios instanceof PDOException) {
  echo "<h2>Erro na busca do banco de dados.</h2>";
  if (AMBIENTE_DEV) {
    echo $usuarios;
  }

  return;
}

include_once(__DIR__ . "/acoes/adquirir-informacao-do-usuario.php");
include_once(__DIR__ . "/componentes/configuracao-da-pagina.html");

?>
<title>Adotaí | Lista de usuários</title>
</head>

<body class="d-flex flex-column min-vh-100">
  <?php
  include_once(__DIR__ . "/componentes/navbar.html");

  if (!$usuarios):
    echo "<h1>Sem usuários!</h1>";

    return;
  endif;
  ?>
  <div class="flex-fill">
    <div class="container">
      <h4><a href="/adotai/view/pagina-principal.php" class="text-black text-decoration-none"><i class="bi bi-caret-left-fill"></i>Voltar</a></h4>
      <div class="table-responsive mt-5">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th>Número de telefone</th>
              <th>Nome</th>
              <th>Data de nascimento</th>
              <th>CEP</th>
              <th>Complemento</th>
              <th>Tipo de usuário</th>
              <th>Página de perfil</th>
              <th>Banido?</th>
              <th>Banir / desbanir</th>
              <th class="text-danger">Excluir</th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($usuarios as $dadosUsuario):
            ?>
              <tr>
                <td><?= $dadosUsuario->getIdUsu() ?></td>
                <td><?= $dadosUsuario->getTelefoneUsu() ?></td>
                <td><?= $dadosUsuario->getNomeUsu() ?></td>
                <td><?= $dadosUsuario->getDataNascimentoUsu() ?></td>
                <td><?= $dadosUsuario->getCepUsu() ?></td>
                <td><?= $dadosUsuario->getComplementoUsu() ?></td>
                <td><?= $dadosUsuario->getTipoUsu() === "c" ? "Comum" : "Administrador" ?></td>
                <td><a class="text-decoration-none" href="/adotai/view/pagina-usuario.php/?idUsu=<?= $dadosUsuario->getIdUsu() ?>" target="_blank">Página</a></td>
                <td><?= $dadosUsuario->getBanidoUsu() ? "Sim" : "Não" ?></td>
                <td>
                  <?php
                  if ($dadosUsuario->getTipoUsu() === "a"):
                  ?>
                    -
                    <?php
                  else:
                    if ($dadosUsuario->getBanidoUsu()):
                    ?>
                      <a class="text-white text-decoration-none bg-success fs-3 ps-1 pe-1 rounded-3" href="/adotai/view/acoes/banir-desbanir.php/?idUsu=<?= $dadosUsuario->getIdUsu() ?>&banir=0" onclick="return confirm('Deseja mesmo desbanir o usuário <?= $dadosUsuario->getNomeUsu() ?>?')">
                        <i class="bi bi-slash-circle"></i>
                      </a>
                    <?php
                    else:
                    ?>
                      <a class="text-white text-decoration-none bg-danger fs-3 ps-1 pe-1 rounded-3" href="/adotai/view/acoes/banir-desbanir.php/?idUsu=<?= $dadosUsuario->getIdUsu() ?>&banir=1" onclick="return confirm('Deseja mesmo banir o usuário <?= $dadosUsuario->getNomeUsu() ?>?')">
                        <i class="bi bi-slash-circle"></i>
                      </a>
                  <?php
                    endif;
                  endif;
                  ?>
                </td>
                <td>
                  <?php
                  if ($dadosUsuario->getTipoUsu() === "a"):
                  ?>
                    -
                  <?php
                  else:
                  ?>
                    <a class="text-white text-decoration-none bg-danger fs-3 ps-1 pe-1 rounded-3" href="/adotai/view/acoes/excluir-conta.php/?idUsu=<?= $dadosUsuario->getIdUsu() ?>" onclick="return confirm('Deseja mesmo deletar o usuário <?= $dadosUsuario->getNomeUsu() ?>?')">
                      <i class="bi bi-x-octagon"></i>
                    </a>
                  <?php
                  endif;
                  ?>
                </td>
              </tr>
            <?php
            endforeach;
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
<?php
include_once(__DIR__ . "/componentes/footer.html");
