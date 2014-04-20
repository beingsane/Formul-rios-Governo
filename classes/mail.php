<?php
class MAIL
{
    public static $email = 'fulano@fulano.com';

    public static function sender($params, $formulario, $template)
    {
        $opcoes = [];

        $opcoes['form1'] = [
            '1' => '1.1 Curso Livre: Qualificação em  Agente de Combate às Endemias',
            '2' => '1.2 Curso Técnico em Prótese Dentária',
            '3' => '1.3 Curso Técnico em Enfermagem',
            '4' => '1.4 Curso de Especialização Profissional de Nível Técnico em Enfermagem em Urgência e Emergência',
            '5' => '1.5 Curso Técnico em Vigilância em Saúde'
        ];

       $opcoes['form2'] = [
            '1' => '1.1 Curso Livre: Qualificação em Agente de Combate ás Endemias',
            '2' => '1.2 Curso Técnico em Prótese Dentária',
            '3' => '1.3 Curso de Prevenção da Morte Materna e Neonatal',
            '4' => '1.4 Curso Técnico em Enfermagem',
            '5' => '1.5 Curso de Especialização Profissional de Nível Técnico em Enfermagem em Urgência e Emergência',
            '6' => '1.6 Curso Técnico em Saúde Bucal',
            '7' => '1.1 Curso Livre: Qualificação em Agente de Combate ás Endemias',
            '8' => '1.2 Curso Técnico em Prótese Dentária',
            '9' => '1.3 Curso de Prevenção da Morte Materna e Neonatal',
            '10' => '1.4 Curso Técnico em Enfermagem',
            '11' => '1.5 Curso de Especialização Profissional de Nível Técnico em Enfermagem em Urgência e Emergência',
            '12' => '1.1 Atenção Primári',
            '13' => '1.2 Urgência e Emergência',
            '14' => '1.3 Atenção Psicossocial',
            '15' => '1.4 Gestão em Saúde Pública',
            '16' => '1.5 Sistemas de Informação em Saúde',
            '17' => '1.6 Obstetrícia (pré-natal e parto)'
        ];


    	$nomeForm  = $formulario['tipo'];
    	$opcaoForm = (int) $formulario['opcao'];

    	$formulario['Arquivo'] = __DIR__ . '/arquivos_anexados/'.$_FILES['curriculum']['file_cmp'];

    	if ($nomeForm == 'form1') {

    		$nn     = '';
    		$cargos = '';

    		foreach ($formulario['opcao'] as $value) {
    			$escolhas = $opcoes[$nomeForm];
    			$escolhas = $escolhas[$opcaoForm];
    			$nn .= ' '.$escolhas.' e';
    			$cargos .= $escolhas. PHP_EOL;
    		}

    		$nn = substr($nn, 0, -2);
    		$titulo = 'Parabéns, sua inscrição foi concluida!';
    		$formulario['opcao'] = nl2br($cargos);

    	} elseif ($nomeForm == 'form2') {
    		$escolhas = $opcoes[$nomeForm];
    		$escolhas = $escolhas[$opcaoForm];

            $titulo = 'Parabéns, sua inscrição foi concluida!';

            $formulario['opcao'] = $escolhas;
    	}

    	$msg = '';

        foreach ($formulario as $key => $value) {

        	if ($key == 'concordo' or $key == 'tipo') {
        		continue;
        	} elseif ($key == 'org_expedidor') {
        		$key = 'Orgão Expedidor';
        	} elseif ($key == 'endereco') {
        		$key = "Endereço";
        	} elseif ($key == 'opcao') {
        		$key = 'Opçao';
        	} elseif ($key == 'nome') {
        		$value = ucfirst(strtolower($value));
        	}

            $msg .=  "\t<tr>\n\t\t<td class=\"texto\" style=\"color:#484848\"><span class=\"style1\">".ucfirst($key)." : $value</span></td>\n\t</tr>\n";
        }

        if (is_string($params)) {
            switch ($params) {
                case 'ALL':
                    $email = self::$email;
                    break;

                default:
                    $email = 'fulano@fulano.com';
                    break;
            }
        }


    	DB::inserir($formulario);

    	/* Envia E-mail para responsavél */
    	$e = new Email('[Inscrição] '.$formulario['nome'], $formulario['e-mail'], $template);
    	$e->SetLanguage('br');
    	$e->varTemplate('msg', $msg );
    	$e->AddAddress($email);
    	$e->setServidorUsuarioSenha(SERVIDOR_EMAIL, USUARIO_EMAIL, SENHA_EMAIL);
    	$enviada = $e->enviaMail('Nova inscrição realizada!');

    	unset($formulario['Arquivo']);

    	$msg = '';

    	foreach ($formulario as $key => $value) {

    		if ($key == 'concordo' or $key == 'tipo') {
    			continue;
    		} elseif ($key == 'org_expedidor') {
    			$key = 'Orgão Expedidor';
    		} elseif ($key == 'endereco') {
    			$key = "Endereço";
    		} elseif ($key == 'opcao') {
    			$key = 'Opçao';
    		} elseif ($key == 'nome') {
    			$value = ucfirst(strtolower($value));
    		}

    		$msg .=  "\t<tr>\n\t\t<td class=\"texto\" style=\"color:#484848\"><span class=\"style1\">".ucfirst($key)." : $value</span></td>\n\t</tr>\n";
    	}

		/* Envia e-mail para o incrito */
    	$e = new Email('Secretaria do Estado da Saúde', $email, $template);
    	$e->SetLanguage('br');
    	$e->varTemplate('msg', $msg );
    	$e->AddAddress($formulario['e-mail']);
    	$e->setServidorUsuarioSenha(SERVIDOR_EMAIL, USUARIO_EMAIL, SENHA_EMAIL);
    	$enviada = $e->enviaMail($titulo);
	}
}
