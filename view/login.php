<?php
include_once(__DIR__ . "/componentes/configuracao-da-pagina.php");
?>

<title>Adotaí | Entrar</title>
</head>

<body>
  <section class="container elementos-entrar d-flex flex-column align-items-center">
    <img src="/adotai/util/logo-inteira.png" class="col-lg-2 col-4">
    <div class="d-flex justify-content-center p-3 w-100">
      <div class="entrar card col-lg-4 col-10">
        <div class="cabeca-entrar card-header text-white">
          <h1>Entrar</h1>
        </div>
        <div class="card-body d-flex justify-content-center p-4">
          <div class="form-group w-100">
            <form action="/adotai/view/acoes/entrar.php" method="post" class="d-flex flex-column align-items-center">
              <div class="col-12">
                <span class="text-white col-6">Número de telefone</span>
                <input type="text" id="input-numero" name="input-numero" placeholder="informe seu número..." class="col-12 form-control">
              </div>
              <div class="mt-4 col-12">
                <span class="text-white">Senha</span>
                <input type="password" id="input-senha" name="input-senha" placeholder="informe sua senha..." class="col-12 form-control">
              </div>
              <div class="mt-3 col-12">
                <a href="/adotai/view/cadastro.php" class="text-white text-decoration-none">Não é cadastrado?</a><br>
                <a href="" class="text-white text-decoration-none">Esqueceu sua senha?</a>
              </div>
              <div class="mt-4 col-6">
                <button class="col-12 btn bg-white" id="botao-entrar" type="submit">Entrar</button>
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