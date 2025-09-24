<?php
include_once(__DIR__ . "/acoes/registrar-cadastro.php");
include_once(__DIR__ . "/acoes/adquirir-informacao-do-usuario.php");
include_once(__DIR__ . "/componentes/configuracao-da-pagina.html");

if ($usuario) {
  header("location: /adotai/view/pagina-principal.php");
}
?>

<title>Adotaí | Cadastrar-se</title>
</head>

<body>
  <section class="container elementos-cadastrar d-flex flex-column align-items-center">
    <img src="/adotai/util/logo-inteira.png" class="col-lg-2 col-4">
    <div class="d-flex justify-content-center p-3 w-100 mb-5">
      <div class="cadastrar card col-lg-8 col-10">
        <div class="cabeca-cadastrar card-header text-white d-flex justify-content-between align-items-center">
          <h1>Cadastrar-se</h1>
          <h4><a href="/adotai/view/login.php" class="float-end text-white text-decoration-none"><i class="bi bi-caret-left-fill"></i>Voltar</a></h4>
        </div>
        <div class="card-body d-flex justify-content-center p-4">
          <div class="form-group w-100">
            <form action="" method="post">
              <div class="d-flex flex-row">
                <div class="form-cadastrar-esquerda col-6 float-start p-2">
                  <div class="col-12">
                    <span class="text-white col-6">Nome *</span>
                    <input value="<?= $cadastro ? $cadastro->getNomeUsu() : null ?>" type="text" id="input-nome" name="input-nome" placeholder="informe seu nome..." class="col-12 form-control">
                  </div>
                  <div class="col-12 mt-4">
                    <span class="text-white col-6">Número de telefone *</span>
                    <input value="<?= $cadastro ? $cadastro->getTelefoneUsu() : null ?>" type="text" id="input-numero" name="input-numero" placeholder="informe seu número..." class="col-12 form-control">
                  </div>
                  <div class="mt-4 col-12">
                    <span class="text-white">Senha *</span>
                    <input type="password" id="input-senha" name="input-senha" placeholder="informe uma senha..." class="col-12 form-control">
                  </div>
                  <div class="mt-4 col-12">
                    <span class="text-white">Confirmar senha *</span>
                    <input type="password" id="input-confirmar-senha" name="input-confirmar-senha" placeholder="informe a mesma senha..." class="col-12 form-control">
                  </div>
                </div>
                <div class="form-cadastrar-direita col-6 float-end p-2">
                  <div class="col-12">
                    <span class="text-white col-6">Data de nascimento *</span>
                    <input value="<?= $cadastro ? $cadastro->getDataNascimentoUsu() : null ?>" type="date" id="input-data-nasc" name="input-data-nasc" class="col-12 form-control">
                  </div>
                  <div class="col-12 mt-4">
                    <span class="text-white col-6">CEP *</span>
                    <input value="<?= $cadastro ? $cadastro->getCepUsu() : null ?>" type="text" id="input-cep" name="input-cep" placeholder="informe seu CEP..." class="col-12 form-control">
                  </div>
                  <div class="col-12 mt-4">
                    <span class="text-white col-6">Complemento de endereço</span>
                    <input value="<?= $cadastro ? $cadastro->getComplementoUsu() : null ?>" type="text" id="input-complemento" name="input-complemento" placeholder="informe um complemento de endereço..." class="col-12 form-control">
                  </div>
                </div>
              </div>
              <?php if ($mensagensDeInvalidade): ?>
                <div class="mt-3 text-white p-2">
                  <?= $mensagensDeInvalidade ?>
                </div>
              <?php endif; ?>
              <div class="mt-4 col-12 d-flex justify-content-center">
                <button class="col-6 btn bg-white" id="botao-cadastrar" type="submit">Cadastrar-se</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>

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
</script>

</html>