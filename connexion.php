<?php 

define("DB_HOST", "localhost") ;
define("DB_USERNAME", "root") ;
define("DB_PASSWORD", "") ;
define("DB_NAME", "ay00819w") ;

// se connecter à la base de donnée 
function connect(){
    try{
        $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME ;

        $pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD);        
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) ;
        return $pdo ;
    } catch (PDOException $e){
        echo 'ERREUR !: '. $e->getMessage() . '<br>' ;
        die() ;
    }
}
