<?php

class Requisicao
{
    public function __construct(){

        if(count($_POST) <= 0)
            header('Location: /form');

        if (isset($_POST['tipo']) 
        	  and ($_POST['tipo'] == 'form1' 
        	   || $_POST['tipo'] == 'form2') 
        ) {
            $this->formSend1($_POST);
        }else{
            echo 'Nenhum tipo encontrado';
        }

    }

    private function formSend1(array $dados)
    {
        $dados = array_change_key_case($dados, CASE_LOWER);

        foreach ($dados as $key => $value) {

            if (is_string($dados[$key]))
                $dados[$key] = trim($dados[$key]);
        }

        if (! array_key_exists('tipo',$dados)) {
            echo 'Erro no sistema, por favor contacte o administrador do'
		 . 'sistema, ou tente novamente!';
        	exit;
        }

	   $validar = new Verificacao();
       $msg = $validar->validacao($dados);

    	$msg = utf8_encode($msg);

        if(! $msg) {
            MAIL::sender("ALL", $dados, PATH_TEMPLATE . '/fmt_inscricao.htm');

        	require "html/Topo_conclusao.html";
        	require "html/concluido.html";
        	require "html/Rodape.html";
        	exit;
        }


        if (empty($msg))
            unset($msg);


    	if ($dados['tipo'] == 'form1' ) {
    		require "html/Topo.html";
			require "html/formulario.html";
    	} else {
       		require "html/Topo2.html";
    		require "html/formulario2.html";

    	}

        require "html/Rodape.html";
    }
}
