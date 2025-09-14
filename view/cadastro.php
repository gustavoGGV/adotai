<?php
include_once(__DIR__ . "/componentes/configuracao-da-pagina.php");
?>

<title>Adotaí | Cadastrar-se</title>
</head>

<body>
  <section class="container elementos-cadastrar d-flex flex-column align-items-center">
    <img src="/adotai/util/logo-inteira.png" class="col-lg-2 col-4">
    <div class="d-flex justify-content-center p-3 w-100">
      <div class="cadastrar card col-lg-8 col-10">
        <div class="cabeca-cadastrar card-header text-white">
          <h1>Cadastrar-se</h1>
        </div>
        <div class="card-body d-flex justify-content-center p-4">
          <div class="form-group w-100">
            <form action="/adotai/view/acoes/registrar-cadastro.php" method="post">
              <div class="d-flex flex-row">
                <div class="form-cadastrar-esquerda col-6 float-start p-2">
                  <div class="col-12">
                    <span class="text-white col-6">Nome completo *</span>
                    <input type="text" id="input-nome" class="col-12 form-control">
                  </div>
                  <div class="col-12 mt-4">
                    <span class="text-white col-6">Número de telefone *</span>
                    <input type="text" id="input-numero" class="col-12 form-control">
                  </div>
                  <div class="mt-4 col-12">
                    <span class="text-white">Senha *</span>
                    <input type="password" id="input-senha" class="col-12 form-control">
                  </div>
                  <div class="mt-4 col-12">
                    <span class="text-white">Confirmar senha *</span>
                    <input type="password" id="input-confirmar-senha" class="col-12 form-control">
                  </div>
                </div>
                <div class="form-cadastrar-direita col-6 float-end p-2">
                  <div class="col-12">
                    <span class="text-white col-6">Data de nascimento *</span>
                    <input type="date" id="input-data-nasc" class="col-12 form-control">
                  </div>
                  <div class="col-12 mt-4">
                    <span class="text-white col-6">CEP *</span>
                    <input type="text" id="input-cep" class="col-12 form-control">
                  </div>
                  <div class="col-12 mt-4">
                    <span class="text-white col-6">Complemento</span>
                    <input type="text" id="input-complemento" class="col-12 form-control">
                  </div>
                </div>
              </div>
              <div class="mt-5 col-12 d-flex justify-content-center">
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
    } else if (apenasOsNumeros.length > 11) {
      numeroFormatado = numeroFormatado.replace(/[\-\(\)\s]/g, "");
    }

    inputNumero.value = numeroFormatado;
  });
</script>

</html>