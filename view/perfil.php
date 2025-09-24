<?php
include_once(__DIR__ . "/acoes/adquirir-informacao-do-usuario.php");
include_once(__DIR__ . "/acoes/alterar-cadastro.php");
include_once(__DIR__ . "/componentes/configuracao-da-pagina.html");

if (!$usuario) :
  header("location: /adotai/view/login.php");
elseif ($usuario->getBanidoUsu()) :
  header("location: /adotai/view/acoes/deslogar.php");
else :
?>
  <title>Adotaí | Perfil</title>
  </head>

  <body>
    <?php
    include_once(__DIR__ . "/componentes/navbar.html");
    ?>
    <form action="" method="post" class="container d-flex flex-lg-row flex-column">
      <div class="imagem-perfil-usuario col-lg-3 col-12">
        <div class="imagem-usuario-container d-flex justify-content-center">
          <img src="/adotai/util/user-cachorro.png" id="imagem-perfil" class="w-lg-75 ms-lg-2">
        </div>
        <div class="selecionar-imagem-perfil d-flex justify-content-center mt-4">
          <span class="text-black">Cachorro</span>
          <input type="radio" value="c" name="input-imagem-cachorro" id="input-imagem-cachorro" class="ms-1" <?= $usuario->getTipoImagemPerfilUsu() === "c" ? "checked" : null ?>>
          <span class="text-black ms-3">Gato</span>
          <input type="radio" value="g" name="input-imagem-gato" id="input-imagem-gato" class="ms-1" <?= $usuario->getTipoImagemPerfilUsu() === "g" ? "checked" : null ?>>
        </div>
      </div>
      <div class="vr d-none d-lg-block col-1"></div>
      <div class="informacoes-usuario col-lg-8 col-12 p-5">
        <div class="d-flex flex-column">
          <div class="col-12">
            <span class="text-black col-6">Nome</span>
            <input value="<?= $usuario->getNomeUsu() ?>" type="text" id="input-nome" name="input-nome" placeholder="informe seu nome..." class="col-12 form-control">
          </div>
          <div class="col-12 mt-4">
            <span class="text-black col-6">Número de telefone</span>
            <input value="<?= $usuario->getTelefoneUsu() ?>" type="text" id="input-numero" name="input-numero" placeholder="informe seu número..." class="col-12 form-control">
          </div>
          <div class="mt-4 col-12">
            <span class="text-black">Senha nova</span>
            <input type="password" id="input-senha-nova" name="input-senha-nova" placeholder="informe a senha nova..." class="col-12 form-control">
          </div>
          <div class="mt-4 col-12" id="confirmacao-senha-nova">
            <span class="text-black">Confirmar senha nova</span>
            <input type="password" id="input-confirmacao-senha-nova" name="input-confirmacao-senha-nova" placeholder="informe a mesma senha nova..." class="col-12 form-control">
          </div>
          <div class="mt-4 col-12" id="senha-atual">
            <span class="text-black">Senha atual</span>
            <input type="password" id="input-senha-atual" name="input-senha-atual" placeholder="informe sua senha atual..." class="col-12 form-control">
          </div>
          <div class="mt-4 col-12">
            <span class="text-black col-6">Data de nascimento</span>
            <input value="<?= $usuario->getDataNascimentoUsu() ?>" type="date" id="input-data-nasc" name="input-data-nasc" class="col-12 form-control">
          </div>
          <div class="col-12 mt-4">
            <span class="text-black col-6">CEP</span>
            <input value="<?= $usuario->getCepUsu() ?>" type="text" id="input-cep" name="input-cep" placeholder="informe seu CEP..." class="col-12 form-control">
          </div>
          <div class="col-12 mt-4">
            <span class="text-black col-6">Complemento de endereço</span>
            <input value="<?= $usuario->getComplementoUsu() ?>" type="text" id="input-complemento" name="input-complemento" placeholder="informe um complemento de endereço..." class="col-12 form-control">
          </div>
        </div>
        <?php if ($mensagensDeInvalidade): ?>
          <div class="mt-3 text-danger p-2">
            <?= $mensagensDeInvalidade ?>
          </div>
        <?php endif; ?>
        <div class="mt-5 col-12 d-flex flex-column align-items-center justify-content-center">
          <button class="botao-alterar col-4 btn text-white" id="botao-alterar" type="submit">Alterar informações</button>
          <a href="/adotai/view/acoes/deslogar.php" class="bg-danger col-4 mt-4 text-white btn">
            Sair
          </a>
          <a href="/adotai/view/acoes/excluir-conta.php/?idUsu=<?= $usuario->getIdUsu() ?>" class="bg-danger col-4 mt-4 text-white btn" onclick="return confirm('Deseja mesmo deletar sua conta?')">
            Excluir conta
          </a>
        </div>
      </div>
    </form>
  </body>
  <?php
  include_once(__DIR__ . "/componentes/footer.html");
  ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

  <script>
    const inputNumero = document.getElementById("input-numero");
    const inputCep = document.getElementById("input-cep");

    inputNumero.addEventListener("input", () => {
      let numeroFormatado = inputNumero.value;
      // Proibir o usuário de digitar caracteres que não sejam números, parênteses, hífens e espaços.
      numeroFormatado = numeroFormatado.replace(/[^\d\(\)\-\s]/g, "");
      const apenasOsNumeros = numeroFormatado.replace(/\D/g, "");

      if (apenasOsNumeros.length === 10) {
        // Formata para "(xx) xxxx-xxxx".
        numeroFormatado = apenasOsNumeros.replace(/(\d{2})(\d{4})(\d{4})/, "($1) $2-$3");
      } else if (apenasOsNumeros.length === 11) {
        // Formata para "(xx) xxxxx-xxxx".
        numeroFormatado = apenasOsNumeros.replace(/(\d{2})(\d{5})(\d{4})/, "($1) $2-$3");
      }

      inputNumero.value = numeroFormatado;
    });

    inputCep.addEventListener("input", () => {
      let cepFormatado = inputCep.value;
      // Proibir o usuário de digitar caracteres que não sejam números e hífens.
      cepFormatado = cepFormatado.replace(/[^\d-]/g, "");
      const apenasOsNumeros = cepFormatado.replace(/\D/g, "");

      if (apenasOsNumeros.length === 8) {
        cepFormatado = apenasOsNumeros.replace(/(\d{5})(\d{2})/, "$1-$2");
      }

      inputCep.value = cepFormatado;
    })

    const inputSenhaNova = document.getElementById("input-senha-nova");
    const confirmacaoSenhaNova = document.getElementById("confirmacao-senha-nova");
    const senhaAtual = document.getElementById("senha-atual");

    // Caso o usuário tenha preenchido algo no campo de senha nova, esses campos aparecerão.
    inputSenhaNova.addEventListener("input", () => {
      confirmacaoSenhaNova.style.display = "block";
      senhaAtual.style.display = "block";
    })

    const imagemPefil = document.getElementById("imagem-perfil");
    const inputImagemCachorro = document.getElementById("input-imagem-cachorro");
    const inputImagemGato = document.getElementById("input-imagem-gato");

    if (inputImagemCachorro.checked) {
      imagemPefil.src = "/adotai/util/user-cachorro.png";
    } else {
      imagemPefil.src = "/adotai/util/user-gato.png";
    }

    inputImagemCachorro.addEventListener("change", () => {
      if (inputImagemCachorro.checked) {
        imagemPefil.src = "/adotai/util/user-cachorro.png";
        inputImagemGato.checked = false;
      }
    })

    inputImagemGato.addEventListener("change", () => {
      if (inputImagemGato.checked) {
        imagemPefil.src = "/adotai/util/user-gato.png";
        inputImagemCachorro.checked = false;
      }
    })
  </script>

  </html>

<?php
endif;
