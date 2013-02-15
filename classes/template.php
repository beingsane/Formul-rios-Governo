<?php
/**
 *
 * @author Jefersson Nathan
 * @date 14/02/13
 * @time 07:39
 * @package Formulário Governo
 */
class Template
{
    public function __construct(){
        require "html/Topo.html";
        require "html/formulario.html";
        require "html/Rodape.html";
    }
}
