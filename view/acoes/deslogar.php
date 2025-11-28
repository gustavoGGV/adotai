<?php

if ($_COOKIE) {
  // Para deletar um cookie, é necessário passar todas as mesmas informações, menos o valor e o tempo de expiramento que é revertido.
  setcookie("idUsu", "", time() - 60 * 60 * 24 * 120, "/", "", false, true);
  setcookie("telefoneUsu", "", time() - 60 * 60 * 24 * 120, "/", "", false, true);
}

header("location: " . URLBASE . "/view/login.php");
