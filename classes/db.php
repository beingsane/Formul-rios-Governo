<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nathan
 * Date: 14/02/13
 * Time: 09:21
 */
class DB
{
    static $estado = 0;
    static $conexao;

    public static function conexao()
    {
        if(self::$estado == 0){
            try{
                self::$conexao =  new PDO('mysql:host=;dbname=','','');
                self::$estado = 1;
                return self::$conexao;
            }catch (PDOException $e){
                echo 'Erro ao conectar-se ao banco de dados '. $e->getMessage() .' ! ';
            	exit;
            }

        }else{
            return self::$conexao;
        }
    }

    public static function inserir(array $dados)
    {
        $db = self::conexao();

    	try{

    	$dados = utf8_encode(serialize($dados));
    	$dados = addslashes($dados);

    	$query = "INSERT INTO `swp_incricoes2013`(id, dados) VALUES(NULL, '".$dados."')";
    	$db->exec($query);

    	} catch(PDOException $e) {
    		echo $e->getMessage();
    	}
;
    }

}
