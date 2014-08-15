<?php
class Verificacao
{
    public function verifica($classe)
    {
        if (class_exists($classe)) {
            return new $classe;
        } else {
            header('Location: /');
        }
    }

	public static function removerAcento($str){
		$str = utf8_decode($str);
		return strtr($str, $from, $to);
	}

	public function validacao(array $dados){

		$msg  = '';
		if (empty($dados['nome'])) {
			$msg .= 'O campo nome não foi preenchido corretamente!'.PHP_EOL;

		}elseif (strlen($dados['nome']) < 3) {
			$msg .= 'O campo nome deve ter no mínimo 3 caracteres'.PHP_EOL;
		}


		if (!preg_match('#^\d+$#', $dados['identidade'])) {
			$msg .= 'O campo identidade só suporta números'.PHP_EOL;
		}

		if (!preg_match('#^\d{3}\.\d{3}\.\d{3}-\d{2}$#', $dados['cpf'])) {
			$msg .= 'O número do CPF informado não é válido'.PHP_EOL;
		}

		if (!preg_match('#^\d{2}\s\d{4}-\d{4}$#', $dados['telefone'])) {
			$msg .= 'O número do telefone não é válido - ex: xx xxxx-xxxx'.PHP_EOL;
		}

		if (!preg_match('#^[A-Za-z0-9._-]+@[A-Za-z]+\.[A-Za-z.]+$#', $dados['e-mail'])) {
			$msg .= 'O email não é válido'.PHP_EOL;
		}

		if (empty($dados['endereco'])) {
			$msg .= 'O campo endereço não foi preenchido!'.PHP_EOL;

			if (strlen($dados['endereco']) < 10) {
				$msg .= 'Informe melhor o seu endereço'.PHP_EOL;
			}
		}

		if ($_FILES['curriculum']['error'] != 0) {
			$msg .= 'Verifique o arquivo que está sendo enviado!'.PHP_EOL;
		} else {


			$rand = time();
			$key_crypt = md5($rand);
			$file_name = $key_crypt . '_' .$_SERVER['REMOTE_ADDR'] . '_' . $_FILES['curriculum']['name'];
			$file_name = str_replace(' ','_', $file_name);

			$file_name = $this->removerAcento($file_name);

			$_FILES['curriculum']['file_cmp'] = $file_name;

			if (is_uploaded_file($_FILES['curriculum']['tmp_name']))
				move_uploaded_file($_FILES['curriculum']['tmp_name'], '/var/www/swapi/istos/sites/ses/form/arquivos_anexados/'.$file_name);
			else
				$msg .= 'Verifique o arquivo que está sendo enviado!'.PHP_EOL;

		}

		/* Referente ao formulário 1 */
		if ( $dados['tipo'] == 'form1') {
			if (isset($dados['opcao'])) {

				$quantidade = count($dados['opcao']);

				if (! ($quantidade <= 2)) {
					$msg .= "Você deve escolher entre 1 e 2 opções".PHP_EOL;
				}

			} else {
				$msg .= "Nenhum cargo foi escolhido".PHP_EOL;
			}

		}

		/* Referente ao formulário 2 */
		if ( $dados['tipo'] == 'form2') {
			if (! isset($dados['opcao'])) {
				$msg .= "Por favor escolha em que cargo deseja inscrever-se ".PHP_EOL;
			}
		}


		if (! isset($dados['concordo'])){
			$msg .= 'Para proseguir, deve concordar com nossos termos'.PHP_EOL;
		}

		return $msg;
	}
}
