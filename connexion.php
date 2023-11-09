<?php 

define("DB_HOST", "aws.connect.psdb.cloud") ;
define("DB_USERNAME", "4hk600v5o3rajn2jfcby") ;
define("DB_PASSWORD", "pscale_pw_zWRkJ9djhRpVPjRCs5Ydp8FyP613APyTNSxhH2qA3vu") ;
define("DB_NAME", "annonceimmo") ;

// se connecter à la base de donnée 
function connect(){
    try{
        $dsn = "mysql:host={$_ENV["DB_HOST"]};dbname={$_ENV["DB_NAME"]}";
        $options = array(
            PDO::MYSQL_ATTR_SSL_CA => "/etc/ssl/certs/ca-certificates.crt",
            );
        $pdo = new PDO($dsn, $_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"], $options);        
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) ;
        return $pdo ;
    } catch (PDOException $e){
        echo 'ERREUR !: '. $e->getMessage() . '<br>' ;
        die() ;
    }
}
