<?php
define('PATH_TEMPLATE',  'xxxxx');
define('SERVIDOR_EMAIL', 'xxxxx');
define('USUARIO_EMAIL',  'xxxxx');
define('SENHA_EMAIL',    'xxxxx');

require 'autoload.php';
require 'classes/verificacao.php';
require 'class.email.php';

$acao = filter_input('c', INPUT_GET) ?: false;

$verify = new Verificacao;
$verify->verifica($acao);
