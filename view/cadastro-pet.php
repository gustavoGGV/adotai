<?php
include_once(__DIR__ . "/acoes/adquirir-informacao-do-usuario.php");
include_once(__DIR__ . "/acoes/cadastrar-pet.php");
require_once(__DIR__ . "/../controller/EspecieController.php");
require_once(__DIR__ . "/../controller/TemperamentoController.php");

$especieController = new EspecieController();
$temperamentoController = new TemperamentoController();
$especies = $especieController->pegarEspecies();
$temperamentos = $temperamentoController->pegarTemperamentos();

include_once(__DIR__ . "/componentes/configuracao-da-pagina.html");
?>
<title>Adotaí | Cadastrar Pet</title>
</head>

<body>
  <?php
  include_once(__DIR__ . "/componentes/navbar.html");
  ?>

  <div class="container">
    <h4><a href="/adotai/view/pagina-principal.php" class="text-black text-decoration-none"><i class="bi bi-caret-left-fill"></i>Voltar</a></h4>
  </div>
  <form action="" method="post" class="container d-flex flex-column">
    <div class="mt-3 mb-3">
      <span>Nome *</span>
      <input value="<?= $cadastro && $cadastro->getNomePet() ? $cadastro->getNomePet() : null ?>" class="form-control mt-2" id="input-nome-pet" name="input-nome-pet" class="form-control" type="text" placeholder="nome do pet...">
    </div>
    <div class="mb-3">
      <span>Sexo *</span>
      <select class="mt-2 form-control" id="select-sexo-pet" name="select-sexo-pet">
        <option value="">escolha...</option>
        <option value="m" <?= $cadastro && $cadastro->getSexoPet() === "m" ? "selected" : null ?>>masculino</option>
        <option value="f" <?= $cadastro && $cadastro->getSexoPet() === "f" ? "selected" : null ?>>feminino</option>
      </select>
    </div>
    <div class="mb-3">
      <span>É de raça? *</span>
      <select class="mt-2 form-control" id="select-raca-pet" name="select-raca-pet">
        <option value="">escolha...</option>
        <option value="0" <?= $cadastro && $cadastro->getTemRacaPet() === "0" ? "selected" : null ?>>não</option>
        <option value="1" <?= $cadastro && $cadastro->getTemRacaPet() === "1" ? "selected" : null ?>>sim</option>
      </select>
    </div>
    <div class="mb-3">
      <span>Espécie *</span>
      <select class="mt-2 form-control" id="select-especie-pet" name="select-especie-pet">
        <option value="">escolha...</option>
        <?php
        foreach ($especies as $especie):
        ?>
          <option value="<?= $especie->getIdEsp() ?>" <?= $cadastro && $cadastro->getEspecie()->getIdEsp() === $especie->getIdEsp() ? "selected" : null ?>><?= $especie->listarEspecie() ?></option>
        <?php
        endforeach;
        ?>
      </select>
    </div>
    <div class="mb-3">
      <span>Temperamento *</span>
      <select class="mt-2 form-control" id="select-temperamento-pet" name="select-temperamento-pet">
        <option value="">escolha...</option>
        <?php
        foreach ($temperamentos as $temperamento):
        ?>
          <option value="<?= $temperamento->getIdTem() ?>" <?= $cadastro && $cadastro->getTemperamento()->getIdTem() === $temperamento->getIdTem() ? "selected" : null ?>><?= $temperamento->listarTemperamento() ?></option>
        <?php
        endforeach;
        ?>
      </select>
    </div>
    <div class="mb-3">
      <span>Link de imagem *</span>
      <input value="<?= $cadastro && $cadastro->getLinkImagemPet() ? $cadastro->getLinkImagemPet() : null ?>" class="form-control mt-2" id="input-imagem-pet" name="input-imagem-pet" class="form-control" type="text" placeholder="link de uma imagem do pet...">
    </div>
    <div class="mb-3">
      <span>Descrição *</span>
      <input value="<?= $cadastro && $cadastro->getDescricaoPet() ? $cadastro->getDescricaoPet() : null ?>" class="form-control mt-2" id="input-descricao-pet" name="input-descricao-pet" class="form-control" type="text" placeholder="descrição do pet...">
    </div>
    <?php if ($mensagensDeInvalidade): ?>
      <div class="mt-3 text-danger p-2">
        <?= $mensagensDeInvalidade ?>
      </div>
    <?php endif; ?>
    <div class="col-12 d-flex justify-content-center">
      <button type="submit" class="mt-3 botao-cadastrar-pet btn col-4 text-white">Cadastrar</button>
    </div>
  </form>
</body>

<?php
include_once(__DIR__ . "/componentes/footer.html");
