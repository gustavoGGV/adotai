<?php

require_once(__DIR__ . "/../controller/UsuarioController.php");

$usuarioController = new UsuarioController();

include_once(__DIR__ . "/acoes/adquirir-informacao-do-usuario.php");
include_once(__DIR__ . "/acoes/adquirir-informacoes-dos-pets.php");
include_once(__DIR__ . "/componentes/configuracao-da-pagina.html");

if (!$usuario):
  header("location: /adotai/view/login.php");
elseif ($usuario->getBanidoUsu()):
  header("location: /adotai/view/acoes/deslogar.php");
else:
?>
  <title>Adotaí | Pagina principal</title>
  </head>

  <body>
    <?php include_once(__DIR__ . "/componentes/navbar.html") ?>

    <div class="container">
      <div class="p-3 d-flex">
        <a href="/adotai/view/pets-proprios.php" class="me-3 text-decoration-none">
          <button class="botao-pagina-principal btn text-white text-decoration-none">Meus pets</button>
        </a>
        <a href="/adotai/view/cadastro-pet.php" class="me-3 text-decoration-none">
          <button class="botao-pagina-principal btn text-white text-decoration-none">Cadastrar pet</button>
        </a>
        <?php
        if ($usuario->getTipousu() === "a"):
        ?>
          <a href="/adotai/view/lista-usuarios.php" class="me-3 text-decoration-none">
            <button class="botao-pagina-principal btn text-white text-decoration-none">Lista de usuários</button>
          </a>
          <a href="/adotai/view/lista-pets.php" class="me-3 text-decoration-none">
            <button class="botao-pagina-principal btn text-white text-decoration-none">Lista de pets</button>
          </a>
        <?php
        endif;
        ?>
      </div>
    </div>
    <div class="container-lg d-flex flex-lg-row flex-column align-items-center">
      <?php
      if (!$pets):
        echo "<h1>Sem pets!</h1>";

        return;
      endif;

      $numeroDeCards = 0;
      foreach ($pets as $pet):
        $dadosDoAcolhedor = $usuarioController->encontrarUsuarioPorId($pet->getAcolhedor()->getIdUsu());

        if (!$dadosDoAcolhedor->getBanidoUsu()):
      ?>
          <div class="p-3 col-lg-4 col-11">
            <div class="card-pet card">
              <a href="<?= $pet->getLinkImagemPet() ?>" target="_blank" class="cabeca-card-pet card-header p-4 d-flex justify-content-center">
                <img src="<?= $pet->getLinkImagemPet() ?>" class="imagem-pet img-fluid rounded-2 w-100">
              </a>
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
                  <p class="fw-bold me-1">Acolhedor:</p>
                  <a href="/adotai/view/pagina-usuario.php/?idUsu=<?= $pet->getAcolhedor()->getIdUsu() ?>" class="text-white text-break"><?= $pet->getAcolhedor()->getNomeUsu() ?></a>
                </div>
              </div>
            </div>
          </div>
      <?php
          $numeroDeCards++;

          if ($numeroDeCards === 3) {
            echo "</div>\n<div class='container-lg d-flex flex-lg-row flex-column align-items-center'>";
            $numeroDeCards = 0;
          }
        endif;
      endforeach;
      ?>
    </div>
  </body>
<?php
  include_once(__DIR__ . "/componentes/footer.html");
endif;
