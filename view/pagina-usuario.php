<?php
require_once(__DIR__ . "/../controller/UsuarioController.php");
require_once(__DIR__ . "/../controller/PetController.php");
include_once(__DIR__ . "/acoes/adquirir-informacao-do-usuario.php");
include_once(__DIR__ . "/componentes/configuracao-da-pagina.html");

$dadosDoPerfilAcessado = null;

if (!$usuario) {
  header("location: /adotai/view/login.php");
} else if ($usuario->getBanidoUsu()) {
  header("location: /adotai/view/acoes/deslogar.php");
}

if (!isset($_GET["idUsu"])) {
  header("location: /adotai/view/pagina-principal.php");
} else {
  $usuarioController = new UsuarioController();
  $dadosDoPerfilAcessado = $usuarioController->encontrarUsuarioPorId($_GET["idUsu"]);

  if ($dadosDoPerfilAcessado instanceof PDOException) {
    echo "<h1>Este usuário não existe.</h1>";

    return;
  }

  $petController = new PetController();
  $petsAcolhidosPeloPerfilAcessado = $petController->buscarPetsPorIdDeUsuário($_GET["idUsu"]);
}
?>

<title>Adotaí | Usuário</title>
</head>

<body>
  <?php
  include_once(__DIR__ . "/componentes/navbar.html");
  ?>

  <div class="container d-flex flex-column">
    <?php
    if ($usuario && $usuario->getTipoUsu() === "a"):
      if (!$usuario->getBanidoUsu()):
    ?>
        <a href="/adotai/view/acoes/banir-desbanir.php/?idUsu=<?= $dadosDoPerfilAcessado->getIdUsu() ?>&banir=1">
          <button class="btn bg-danger mb-4 text-white text-decoration-none" onclick="return confirm('Deseja mesmo banir o usuário <?= $dadosDoPerfilAcessado->getNomeUsu() ?>?')">
            Banir usuário
          </button>
        </a>
      <?php
      else:
      ?>
        <a href="/adotai/view/acoes/banir-desbanir.php/?idUsu=<?= $dadosDoPerfilAcessado->getIdUsu() ?>&banir=0">
          <button class="btn bg-danger mb-4 text-white text-decoration-none" onclick="return confirm('Deseja mesmo banir o usuário <?= $dadosDoPerfilAcessado->getNomeUsu() ?>?')">
            Desbanir <?= $dadosDoPerfilAcessado->getNomeUsu() ?>
          </button>
        </a>
      <?php
      endif;
    endif;
    if ($dadosDoPerfilAcessado->getBanidoUsu()):
      ?>
      <h1>Este usuário está banido.</h1>
    <?php
    else:
    ?>
      <div class="card">
        <div class="imagem-perfil-acessado card-body p-4 d-flex justify-content-center">
          <img src="/adotai/util/<?= $dadosDoPerfilAcessado->getTipoImagemPerfilUsu() === "g" ? "user-gato.png" : "user-cachorro.png" ?>" class="img-fluid col-xxl-2 col-lg-3 col-4">
        </div>
        <hr>
        <div class="dados-perfil-acessado card-body p-4">
          <div class="d-flex">
            <h2 class="fw-bold me-3">Nome:</h2>
            <h2><?= $dadosDoPerfilAcessado->getNomeUsu() ?></h2>
          </div>
          <div class="d-flex">
            <h2 class="fw-bold me-3">Número de telefone:</h2>
            <h2><?= $dadosDoPerfilAcessado->getTelefoneUsu() ?></h2>
          </div>
          <div class="d-flex">
            <h2 class="fw-bold me-3">Data de nascimento:</h2>
            <h2><?= $dadosDoPerfilAcessado->getDataNascimentoUsu() ?></h2>
          </div>
          <div class="d-flex">
            <h2 class="fw-bold me-3">Tipo de usuário:</h2>
            <h2><?= $dadosDoPerfilAcessado->getTipoUsu() === "c" ? "comum" : "administrador" ?></h2>
          </div>
        </div>
        <hr>
        <div class="pets-acolhidos-pelo-perfil-acessado p-4">
          <h2 class="fw-bold">Pets acolhidos:</h2>
          <div class="container-lg d-flex flex-lg-row flex-column justify-content-between align-items-center">
            <?php
            if (!$petsAcolhidosPeloPerfilAcessado):
              echo "<h2>Nenhum pet encontrado.</h2>";
            else:
              $numeroDeCards = 0;
              foreach ($petsAcolhidosPeloPerfilAcessado as $pet):
            ?>
                <div class="p-3 col-lg-4 col-11">
                  <div class="card-pet card">
                    <div class="cabeca-card-pet card-header p-4 d-flex justify-content-center">
                      <img src="<?= $pet->getLinkImagemPet() ?>" class="imagem-pet img-fluid rounded-2 w-100">
                    </div>
                    <div class="corpo-card-pet p-4 card-body text-white">
                      <div class="d-flex justify-content-center">
                        <h2 class="fw-bold mb-3"><?= $pet->getNomePet() ?></h2>
                      </div>
                      <div class="d-flex">
                        <p class="fw-bold me-1">Sexo:</p>
                        <p class="text-break"><?= $pet->getSexoPet() === "m" ? "masculino" : "feminino" ?></p>
                      </div>
                      <div class="d-flex">
                        <p class="fw-bold me-1">Tem raça:</p>
                        <p class="text-break"><?= $pet->getTemRacaPet() ? "sim" : "não" ?></p>
                      </div>
                      <div class="d-flex">
                        <p class="fw-bold me-1">Espécie:</p>
                        <p class="text-break"><?= $pet->getEspecie()->listarEspecie() ?></p>
                      </div>
                      <div class="d-flex">
                        <p class="fw-bold me-1">Temperamento:</p>
                        <p class="text-break"><?= $pet->getTemperamento()->listarTemperamento() ?></p>
                      </div>
                      <div class="d-flex">
                        <p class="fw-bold me-1">Descrição:</p>
                        <p class="text-break"><?= $pet->getDescricaoPet() ?></p>
                      </div>
                    </div>
                  </div>
                </div>
            <?php
                $numeroDeCards++;

                if ($numeroDeCards === 3 && count($petsAcolhidosPeloPerfilAcessado) % 3 != 0) {
                  echo "</div>\n<div class='container-lg d-flex flex-lg-row flex-column justify-content-between align-items-center'>";
                  $numeroDeCards = 0;
                }
              endforeach;
            endif;
            ?>
          </div>
        </div>
      </div>
    <?php
    endif;
    ?>
  </div>
</body>

<?php
if (!$dadosDoPerfilAcessado->getBanidoUsu()) {
  include_once(__DIR__ . "/componentes/footer.html");
}
