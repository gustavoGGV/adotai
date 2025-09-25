<?php

// Configurar essas variáveis de acordo com o seu ambiente
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_SENHA", "");

// Ambiente DEV
define("AMBIENTE_DEV", true);

// Mostrar erros do PHP
if (AMBIENTE_DEV) {
  ini_set('display_errors', 1);
  error_reporting(E_ALL);
}
