<?php
include_once(__DIR__ . "/acoes/adquirir-informacao-do-usuario.php");
include_once(__DIR__ . "/acoes/adquirir-informacoes-dos-pets-do-usuario.php");
include_once(__DIR__ . "/componentes/configuracao-da-pagina.html");

if (!$usuario) {
  header("location: /adotai/view/login.php");
} else if ($usuario->getBanidoUsu()) {
  header("location: /adotai/view/acoes/deslogar.php");
}
?>
<title>Adotaí | Meus Pets</title>
</head>

<body>
  <?php include_once(__DIR__ . "/componentes/navbar.html") ?>

  <div class="container">
    <h4><a href="/adotai/view/pagina-principal.php" class="text-black text-decoration-none"><i class="bi bi-caret-left-fill"></i>Voltar</a></h4>
  </div>

  <div class="container-lg d-flex flex-lg-row flex-column justify-content-between align-items-center">
    <?php
    if (!$pets):
      echo "<h1 class='fw-bold text-white'>Nenhum pet encontrado!</h1>";
    else:
    ?>
      <?php
      $numeroDeCards = 0;
      foreach ($pets as $pet):
      ?>
        <div class="p-3 col-lg-4 col-11">
          <div class="card-pet card">
            <div class="cabeca-card-pet card-header p-4 d-flex justify-content-center">
              <img src="<?= $pet->getLinkImagemPet() ?>" class="imagem-pet img-fluid rounded-2 w-100">
            </div>
            <div class="corpo-card-pet p-4 card-body text-white">
              <div class="d-flex justify-content-center">
                <h2 class="fw-bold mb-3 text-break"><?= $pet->getNomePet() ?></h2>
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
              <div class="d-flex">
                <a class="text-white text-decoration-none bg-warning fs-3 ps-1 pe-1 rounded-3" href="/adotai/view/cadastro-pet.php/?idPet=<?= $pet->getIdPet() ?>"><i class="bi bi-pencil-square"></i></a>
                <a></a>
              </div>
            </div>
          </div>
        </div>
      <?php
        $numeroDeCards++;

        if ($numeroDeCards === 3) {
          echo "</div>\n<div class='container-lg d-flex flex-lg-row flex-column justify-content-between align-items-center'>";
          $numeroDeCards = 0;
        }
      endforeach;
      ?>
  </div>
</body>
<?php
      include_once(__DIR__ . "/componentes/footer.html");
    endif;
