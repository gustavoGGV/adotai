<?php
include_once(__DIR__ . "/acoes/adquirir-informacao-do-usuario.php");
include_once(__DIR__ . "/acoes/cadastrar-alterar-pet.php");
require_once(__DIR__ . "/../controller/EspecieController.php");
require_once(__DIR__ . "/../controller/TemperamentoController.php");

$especieController = new EspecieController();
$temperamentoController = new TemperamentoController();
$especies = $especieController->pegarEspecies();
$temperamentos = $temperamentoController->pegarTemperamentos();

include_once(__DIR__ . "/componentes/configuracao-da-pagina.html");
?>
<title>Adotaí | <?= isset($_GET["idPet"]) ? "Alterar" : "Cadastrar" ?> Pet</title>
</head>

<body class="d-flex flex-column min-vh-100">
  <span id="confUrlBase" 
        data-url-base="<?= URL_BASE ?>"></span>

<!-- Necessário para a gravação em AJAX -->
  <?php if (!isset($_GET["idPet"])): 
    include_once(__DIR__ . "/acoes/adquirir-informacao-do-usuario.php");
    if (!$usuario):
      header("location: " . URL_BASE . "/view/pagina-principal.php");
    endif; 
  ?>
    <span id="idDoUsuario" data-id-usuario="<?= $usuario->getIdUsu() ?>"></span>
  <?php else: ?>
    <span id="idDoPet" data-id-pet="<?= $_GET["idPet"] ?>"></span>
  <?php endif; ?>

  <?php
  include_once(__DIR__ . "/componentes/navbar.html");
  ?>

  <div class="flex-fill">
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
          <option value="m" <?= $cadastro && $cadastro->getSexoPet() === "m" ? "selected" : null ?>>macho</option>
          <option value="f" <?= $cadastro && $cadastro->getSexoPet() === "f" ? "selected" : null ?>>fêmea</option>
        </select>
      </div>
      <div class="mb-3">
        <span>Espécie *</span>
        <select class="mt-2 form-control" id="select-especie-pet" name="select-especie-pet">
          <option value="">escolha...</option>
          <?php foreach ($especies as $especie): ?>
            <option value="<?= $especie->getIdEsp() ?>"
              <?= $cadastro && $cadastro->getEspecie()->getIdEsp() === $especie->getIdEsp() ? "selected" : "" ?>>
              <?= $especie->listarEspecie() ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3">
        <span>Tem raça? *</span>
        <select class="mt-2 form-control" id="select-tem-raca-pet" name="select-tem-raca-pet">
          <option value="">escolha...</option>
          <option value="1">Sim</option>
          <option value="0">Não</option>
        </select>
      </div>
      <div class="mb-3 d-none">
        <span>Raça *</span>
        <select class="mt-2 form-control" id="select-raca-pet" name="select-raca-pet">
          <option value="">escolha...</option>
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
        <div id="erros" class="mt-3 text-danger p-2">
          <?= $mensagensDeInvalidade ?>
        </div>
      <div class="col-12 d-flex justify-content-between p-3">
        <button type="submit" class="mt-3 botao-cadastrar-pet btn col-5 text-white"><?= isset($_GET["idPet"]) ? "Alterar" : "Cadastrar" ?></button>
        <button type="button" onclick="salvarPetAjax()" class="mt-3 botao-cadastrar-pet-ajax btn col-5 text-white"><?= isset($_GET["idPet"]) ? "Alterar com AJAX" : "Cadastrar com AJAX" ?></button>
      </div>
    </form>
  </div>

  <script>
    const selEspecie = document.querySelector("#select-especie-pet");
    const selTemRaca = document.querySelector("#select-tem-raca-pet");
    const selRaca = document.querySelector("#select-raca-pet");
    const divErro = document.querySelector("#erros");

    const URL_BASE = document.querySelector("#confUrlBase").dataset.urlBase;

    selTemRaca.addEventListener("change", function () {
      const temRaca = this.value;

      if (temRaca === "1") {
        let idEspecie = selEspecie.value;

        const xhr = new XMLHttpRequest();
        xhr.open(
          "GET",
          URL_BASE + "/api/racas_por_especie.php?idEspecie=" + idEspecie,
          true
        );

        // Necessário para atualizar o select só com a mudança do campo "tem racça?".
        xhr.onload = function () {
          if (xhr.status === 200) {
            const racas = JSON.parse(xhr.responseText);
            racas.forEach((raca) => {
              const option = document.createElement("option");
              option.value = raca.id;
              option.text = raca.nome;
              selRaca.appendChild(option);
            });
          } else {
            console.error("Erro na requisição AJAX");
          }
        };

        xhr.send();

        const divPaiSelRaca = selRaca.parentElement;
        divPaiSelRaca.classList.remove("d-none");

        selEspecie.addEventListener("change", function () {
          idEspecie = this.value;

          // Limpa o select de raças
          selRaca.innerHTML = '<option value="">Escolha a raça...</option>';

          if (!idEspecie) return; // nada selecionado, sai

          // AJAX
          const xhr = new XMLHttpRequest();
          xhr.open(
            "GET",
            URL_BASE + "/api/racas_por_especie.php?idEspecie=" + idEspecie,
            true
          );

          xhr.onload = function () {
            if (xhr.status === 200) {
              const racas = JSON.parse(xhr.responseText);
              racas.forEach((raca) => {
                const option = document.createElement("option");
                option.value = raca.id;
                option.text = raca.nome;
                selRaca.appendChild(option);
              });
            } else {
              console.error("Erro na requisição AJAX");
            }
          };

          xhr.send();
        });
      } else {
        const divPaiSelRaca = selRaca.parentElement;
        divPaiSelRaca.classList.add("d-none");

        // Remover valores do select quando a raça for ignorada.
        selRaca.innerHTML = '<option value="">Escolha a raça...</option>';
      }
    });

    // Salvar com AJAX
    function salvarPetAjax() {
      const nomePet = document.querySelector("#input-nome-pet").value;
      const sexoPet = document.querySelector("#select-sexo-pet").value;
      const especiePet = selEspecie.value;
      const temRacaPet = selTemRaca.value;
      const racaPet = selRaca.value;
      const temperamentoPet = document.querySelector("#select-temperamento-pet").value;
      const linkImagemPet = document.querySelector("#input-imagem-pet").value;
      const descricaoPet = document.querySelector("#input-descricao-pet").value;

      let idUsu = null;
      let idPet = null;
      if (document.querySelector("#idDoUsuario")) {
        idUsu = document.querySelector("#idDoUsuario").dataset.idUsuario;
      } else {
        idPet = document.querySelector("#idDoPet").dataset.idPet;
      }

      const dados = new FormData();
      dados.append("nomePet", nomePet);
      dados.append("sexoPet", sexoPet);
      dados.append("especiePet", especiePet);
      dados.append("temRacaPet", temRacaPet);
      dados.append("temperamentoPet", temperamentoPet);
      dados.append("linkImagemPet", linkImagemPet);
      dados.append("descricaoPet", descricaoPet);
      
      // Possíveis nulos.
      dados.append("racaPet", racaPet);
      dados.append("idUsu", idUsu);
      dados.append("idPet", idPet);

      const xhttp = new XMLHttpRequest();

      if (idUsu) {
        xhttp.open("POST", URL_BASE + "/api/cadastrar_pet.php");
      } else {
        xhttp.open("POST", URL_BASE + "/api/atualizar_pet.php");
      }

      xhttp.onload = function() {
        const erros = xhttp.responseText;
        if  (erros) {
          divErro.innerHTML = erros;
        } else {
          window.location = "pets-proprios.php";
        }
      }

      xhttp.send(dados);
    }
  </script>
</body>

<?php
include_once(__DIR__ . "/componentes/footer.html");
