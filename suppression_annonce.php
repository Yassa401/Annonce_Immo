<?php 
    session_start() ;
    include("connexion.php") ;
    include("function.php") ;

    $id_bien = intval($_GET["id"]) ;

    $db = connect() ;

    $query = "DELETE FROM images_biens_immobiliers WHERE id_bien = :id_bien " ;
    $query = $db->prepare($query) ;
    $query->execute([":id_bien" => $id_bien]) ;

    $query = "DELETE FROM biens_location WHERE id_bien = :id_bien " ;
    $query = $db->prepare($query) ;
    $query->execute([":id_bien" => $id_bien]) ;

    $query = "DELETE FROM biens_achat WHERE id_bien = :id_bien " ;
    $query = $db->prepare($query) ;
    $query->execute([":id_bien" => $id_bien]) ;

    $query = "DELETE FROM biens_immobiliers WHERE id = :id_bien " ;
    $query = $db->prepare($query) ;
    $query->execute([":id_bien" => $id_bien]) ;

    header("Location: profil.php") ;
    die ;

?>