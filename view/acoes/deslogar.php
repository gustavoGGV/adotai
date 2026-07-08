<?php

require_once __DIR__ . "/../../util/constantes.php";

if ($_COOKIE) {
  // Para deletar um cookie, é necessário passar todas as mesmas informações, menos o valor e o tempo de expiramento que é revertido.
  setcookie("idUsu", "", [
    "expires" => time() - 60 * 60 * 24 * 120,
    "path" => "/",
    "domain" => "",
    "secure" => true,
    "httponly" => true,
    "samesite" => "None",
  ]);

  setcookie("telefoneUsu", "", [
    "expires" => time() - 60 * 60 * 24 * 120,
    "path" => "/",
    "domain" => "",
    "secure" => true,
    "httponly" => true,
    "samesite" => "None",
  ]);
}

header("location: " . URL_BASE . "/view/login.php");

exit();
