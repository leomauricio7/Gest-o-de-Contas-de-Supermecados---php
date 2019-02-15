<?php
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

session_start();

//Configurações do BD
define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('BD', 'db_sup');
