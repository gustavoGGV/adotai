<?php
include_once(__DIR__ . "/acoes/adquirir-informacao-do-usuario.php");
include_once(__DIR__ . "/componentes/configuracao-da-pagina.html");

if ($usuario):
?>
  <title>Adotaí | Perfil</title>
  </head>

  <body>
    <?php
    include_once(__DIR__ . "/componentes/navbar.html");
    ?>
    <div class="container">
      <div class="imagem-usuario">

      </div>
      <div class="informacoes-usuario">

      </div>
    </div>
  </body>
<?php
  include_once(__DIR__ . "/componentes/footer.html");
else:
  header("location: /adotai/view/login.php");
endif;
