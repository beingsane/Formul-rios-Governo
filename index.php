<?php
define('PATH_TEMPLATE','/var/www/swapi/istos/sites/ses/');
define('SERVIDOR_EMAIL', 'abais.se.gov.br');
define('USUARIO_EMAIL'  ,'xxxxx');
define('SENHA_EMAIL'    ,'xxxx');

require 'classes/verificacao.php';
require 'class.email.php';

function autoload($classe) {
    $classe = strtolower($classe);

    if (file_exists('classes/'.$classe.'.php')) {
        require 'classes/'.$classe.'.php';
    }
}

spl_autoload_register('autoload');

$acao = isset($_GET['c']) ? $_GET['c'] : false;

$verify = new Verificacao;
$verify->verifica($acao);
