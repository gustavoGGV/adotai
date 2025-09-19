<?php

// Configurar essas variáveis de acordo com o seu ambiente
define("DB_HOST", "localhost");
define("DB_USER", "root");
<<<<<<< HEAD
define("DB_SENHA", "sounoob");
=======
define("DB_SENHA", "bancodedados");
>>>>>>> a63e22d (feat: terminar sistema de alteração de usuário)

// Ambiente DEV
define("AMBIENTE_DEV", true);

// Mostrar erros do PHP
if (AMBIENTE_DEV) {
  ini_set('display_errors', 1);
  error_reporting(E_ALL);
}
