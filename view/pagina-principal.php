<?php
include_once(__DIR__ . "/acoes/adquirir-informacao-do-usuario.php");
include_once(__DIR__ . "/componentes/configuracao-da-pagina.php");

if ($usuario):
?>

  <title>Adotaí | Pagina principal</title>
  </head>

  <body>
    <?php include_once(__DIR__ . "/componentes/navbar.html") ?>
  </body>
<?php
  include_once(__DIR__ . "/componentes/footer.php");
else:
  header("location: /adotai/view/login.php");
endif;
