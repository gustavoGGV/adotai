<?php

// Configurar essas variáveis de acordo com o seu ambiente
define("DB_HOST", getEnv("DB_HOST"));
define("DB_PORT", getEnv("DB_PORT"));
define("DB_NAME", getEnv("DB_NAME"));
define("DB_USER", getEnv("DB_USER"));
define("DB_SENHA", getEnv("DB_SENHA"));

// Ambiente DEV
define("AMBIENTE_DEV", getEnv("AMBIENTE_DEV") === "true");

// Mostrar erros do PHP
if (AMBIENTE_DEV) {
    ini_set("display_errors", 1);
    error_reporting(E_ALL);
}

define("URL_BASE", getEnv("URL_BASE"));
