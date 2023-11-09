<?php 

define("HOTE", "localhost") ;
define("UTILISATEUR", "root") ;
define("PASS", "") ;
define("DATABASE", "ay00819w") ;

// se connecter à la base de donnée 
function connect(){
    try{
        $pdo = new PDO('mysql:host='. HOTE . ';dbname=' . DATABASE, UTILISATEUR, PASS) ;
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) ;
        return $pdo ;
    } catch (PDOException $e){
        echo 'ERREUR !: '. $e->getMessage() . '<br>' ;
        die() ;
    }
}
