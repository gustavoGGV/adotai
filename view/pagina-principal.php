<?php
include_once(__DIR__ . "/acoes/adquirir-informacao-do-usuario.php");
include_once(__DIR__ . "/componentes/configuracao-da-pagina.html");

if (!$usuario):
  header("location: /adotai/view/login.php");
else:
?>
  <title>Adotaí | Pagina principal</title>
  </head>

  <body>
    <?php include_once(__DIR__ . "/componentes/navbar.html") ?>
  </body>
<?php
  include_once(__DIR__ . "/componentes/footer.html");
endif;
