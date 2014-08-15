<?php

function autoload($classe) {
    $classe = strtolower($classe);

    if (file_exists('classes/'.$classe.'.php')) {
        require 'classes/'.$classe.'.php';
    }
}

spl_autoload_register('autoload');
