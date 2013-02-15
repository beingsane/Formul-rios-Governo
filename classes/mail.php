<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nathan
 * Date: 14/02/13
 * Time: 09:49
 * To change this template use File | Settings | File Templates.
 */
class MAIL
{
    public static $email = 'jefersson@swapi.com.br';

    public static function sender($params, $formulario, $template)
    {
        $opcoes = array();

        $opcoes['form1'] = array(
            '1' => '1.1 Curso Livre: Qualifica��o em  Agente de Combate �s Endemias',
            '2' => '1.2 Curso T�cnico em Pr�tese Dent�ria',
            '3' => '1.3 Curso T�cnico em Enfermagem',
            '4' => '1.4 Curso de Especializa��o Profissional de N�vel T�cnico em Enfermagem em Urg�ncia e Emerg�ncia',
            '5' => '1.5 Curso T�cnico em Vigil�ncia em Sa�de'
        );

       $opcoes['form2'] = array(
            '1' => '1.1 Curso Livre: Qualifica��o em Agente de Combate �s Endemias',
            '2' => '1.2 Curso T�cnico em Pr�tese Dent�ria',
            '3' => '1.3 Curso de Preven��o da Morte Materna e Neonatal',
            '4' => '1.4 Curso T�cnico em Enfermagem',
            '5' => '1.5 Curso de Especializa��o Profissional de N�vel T�cnico em Enfermagem em Urg�ncia e Emerg�ncia',
            '6' => '1.6 Curso T�cnico em Sa�de Bucal',
            '7' => '1.1 Curso Livre: Qualifica��o em Agente de Combate �s Endemias',
            '8' => '1.2 Curso T�cnico em Pr�tese Dent�ria',
            '9' => '1.3 Curso de Preven��o da Morte Materna e Neonatal',
            '10' => '1.4 Curso T�cnico em Enfermagem',
            '11' => '1.5 Curso de Especializa��o Profissional de N�vel T�cnico em Enfermagem em Urg�ncia e Emerg�ncia',
            '12' => '1.1 Aten��o Prim�ri',
            '13' => '1.2 Urg�ncia e Emerg�ncia',
            '14' => '1.3 Aten��o Psicossocial',
            '15' => '1.4 Gest�o em Sa�de P�blica',
            '16' => '1.5 Sistemas de Informa��o em Sa�de',
            '17' => '1.6 Obstetr�cia (pr�-natal e parto)'
        );


    	$nomeForm = $formulario['tipo'];
    	$opcaoForm = (int) $formulario['opcao'];

    	$formulario['Arquivo'] = 'http://www.saude.se.gov.br/form/arquivos_anexados/'.$_FILES['curriculum']['file_cmp'];

    	if ($nomeForm == 'form1') {

    		$nn = '';
    		$cargos = '';

    		foreach ($formulario['opcao'] as $value) {


    			$escolhas = $opcoes[$nomeForm];
    			$escolhas = $escolhas[$opcaoForm];

    			$nn .= ' '.$escolhas.' e';

    			$cargos .= $escolhas. PHP_EOL;

    		}

    		$nn = substr($nn, 0, -2);


    		$titulo = 'Parab�ns, sua inscri��o foi concluida!';



    		$formulario['opcao'] = nl2br($cargos);

    	} elseif ($nomeForm == 'form2') {
    		$escolhas = $opcoes[$nomeForm];
    		$escolhas = $escolhas[$opcaoForm];

			$titulo = 'Parab�ns, sua inscri��o foi concluida!';

    		$formulario['opcao'] = $escolhas;

    	}

    	$msg = '';

        foreach ($formulario as $key => $value) {

        	if ($key == 'concordo' or $key == 'tipo') {
        		continue;
        	} elseif ($key == 'org_expedidor') {
        		$key = 'Org�o Expedidor';
        	} elseif ($key == 'endereco') {
        		$key = "Endere�o";
        	} elseif ($key == 'opcao') {
        		$key = 'Op�ao';
        	} elseif ($key == 'nome') {
        		$value = ucfirst(strtolower($value));
        	}

            $msg .=  "\t<tr>\n\t\t<td class=\"texto\" style=\"color:#484848\"><span class=\"style1\">".ucfirst($key)." : $value</span></td>\n\t</tr>\n";
        }




        if(is_string($params)){
            switch($params){
                case 'ALL':
                    $email = self::$email;
                    break;
                default:
                    $email = 'jefersson@swapi.com.br';
                    break;
            }
        }


    	DB::inserir($formulario);

    	/* Envia E-mail para responsav�l */
    	$e = new Email('[Inscri��o] '.$formulario['nome'], $formulario['e-mail'], $template);
    	$e->SetLanguage('br');
    	$e->varTemplate('msg', $msg );
    	$e->AddAddress($email);
    	$e->setServidorUsuarioSenha(SERVIDOR_EMAIL, USUARIO_EMAIL, SENHA_EMAIL);
    	$enviada = $e->enviaMail('Nova inscri��o realizada!');

    	unset($formulario['Arquivo']);

    	$msg = '';

    	foreach ($formulario as $key => $value) {

    		if ($key == 'concordo' or $key == 'tipo') {
    			continue;
    		} elseif ($key == 'org_expedidor') {
    			$key = 'Org�o Expedidor';
    		} elseif ($key == 'endereco') {
    			$key = "Endere�o";
    		} elseif ($key == 'opcao') {
    			$key = 'Op�ao';
    		} elseif ($key == 'nome') {
    			$value = ucfirst(strtolower($value));
    		}

    		$msg .=  "\t<tr>\n\t\t<td class=\"texto\" style=\"color:#484848\"><span class=\"style1\">".ucfirst($key)." : $value</span></td>\n\t</tr>\n";
    	}

		/* Envia e-mail para o incrito */
    	$e = new Email('Secretaria do Estado da Sa�de', $email, $template);
    	$e->SetLanguage('br');
    	$e->varTemplate('msg', $msg );
    	$e->AddAddress($formulario['e-mail']);
    	$e->setServidorUsuarioSenha(SERVIDOR_EMAIL, USUARIO_EMAIL, SENHA_EMAIL);
    	$enviada = $e->enviaMail($titulo);








	}
}
