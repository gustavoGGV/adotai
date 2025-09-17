<?php
include_once(__DIR__ . "/acoes/adquirir-informacao-do-usuario.php");
include_once(__DIR__ . "/componentes/configuracao-da-pagina.php");
?>

<title>Adotaí | Pagina principal</title>
</head>

<h1>Olá <?= $usuario["nomeUsu"] ?>!</h1>

<?php
include_once(__DIR__ . "/componentes/footer.php");
