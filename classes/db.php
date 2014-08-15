<?php
class DB
{
    static $conexao = null;
    
    private function __construct(){}
    private function __clone(){}

    public static function getConnection()
    {
        if(self::$conexao) {
            self::$conexao =  new PDO('mysql:host=;dbname=','','');
        }
        
        return self::$conexao;
    }

    public static function inserir(array $dados)
    {
        $db = static::getConnection();

    	try{

    	    $dados = utf8_encode(serialize($dados));
    	    $dados = addslashes($dados);

    	    $query = sprintf(
    	        'INSERT INTO `%s`(dados) VALUES("%s")',
    	        'swp_incricoes2013',
    	        $dados
    	    );
    	    
    	    $db->exec($query);

    	} catch(PDOException $e) {
    		echo $e->getMessage();
    	}
    }

}
