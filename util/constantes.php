<?php

// Configurar essas variáveis de acordo com o seu ambiente
define("DB_HOST", "");
define("DB_USER", "");
define("DB_SENHA", "");

// Ambiente DEV
define("AMBIENTE_DEV", true);

// Mostrar erros do PHP
if (AMBIENTE_DEV) {
  ini_set('display_errors', 1);
  error_reporting(E_ALL);
}

define("URL_BASE", "");

