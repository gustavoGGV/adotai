<?php

require __DIR__ . "/../vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();

// Configurar essas variáveis de acordo com o seu ambiente
define("DB_HOST", $_ENV["DB_HOST"]);
define("DB_PORT", $_ENV["DB_PORT"]);
define("DB_NAME", $_ENV["DB_NAME"]);
define("DB_USER", $_ENV["DB_USER"]);
define("DB_SENHA", $_ENV["DB_SENHA"]);

// Ambiente DEV
define("AMBIENTE_DEV", $_ENV["AMBIENTE_DEV"] === "true");

// Mostrar erros do PHP
if (AMBIENTE_DEV) {
    ini_set("display_errors", 1);
    error_reporting(E_ALL);
}

define("URL_BASE", $_ENV["URL_BASE"]);
