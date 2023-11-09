<?php
session_start() ;
    include('connexion.php') ; 
    include('function.php') ;

    $user_data = check_login() ;

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ImmoHome</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel='stylesheet' href='style_annonce.css'>
  </head>
  <body>
  <header>
    <?php include("header.php") ; ?>
  </header>

    <h1>Annonces biens à vendre : </h1>
    <?php 
    $db = connect() ;
    if (isset($_GET) && count($_GET) > 0 ){
        $prix_min = 0 ;
        $prix_max = 1000000000 ;
        $surface_min = 0 ;
        $surface_max = 65535 ;
        if (isset($_GET['type']) && isset($_GET['ville'])) {
            
            $type = filter_input(INPUT_GET, 'type' ) ;
            $ville = filter_input(INPUT_GET, 'ville') ;
            
            if (isset($_GET['prix_min']) && is_numeric($_GET['prix_min']))
                $prix_min = intval($_GET['prix_min']) ;
            if (isset($_GET['prix_max']) && is_numeric($_GET['prix_max']))
                $prix_max = intval($_GET['prix_max']) ;
            if (isset($_GET['surface_min']) && is_numeric($_GET['surface_min']) )
                $surface_min = intval($_GET['surface_min']) ;
            if (isset($_GET['surface_max']) && is_numeric($_GET['surface_max']))
                $surface_max = intval($_GET['surface_max']) ;
        }

        $query = "SELECT id_bien AS 'id' , prix, id_user, id_ville, surface, type, description 
                FROM biens_achat, biens_immobiliers
                WHERE biens_achat.id_bien = biens_immobiliers.id
                AND biens_immobiliers.type LIKE :type
                AND id_ville = :ville
                AND prix >= :prix_min AND prix <= :prix_max
                AND surface >= :surface_min AND surface <= :surface_max" ;
    
        $query = $db->prepare($query) ;
        $query->execute([":type"=>$type, ':ville'=>$ville , ":prix_min"=>$prix_min, ":prix_max"=>$prix_max, ":surface_min"=> $surface_min, "surface_max"=> $surface_max]) ;    
    }
    else{
        $query = "SELECT id_bien AS 'id' , prix, id_user, id_ville, surface, type, description 
                FROM biens_achat, biens_immobiliers
                WHERE biens_achat.id_bien = biens_immobiliers.id" ;
    
        $query = $db->prepare($query) ;
        $query->execute() ;
    }


    for($i=0 ; $i<$query->rowCount() ; $i++){
        $result = $query->fetch() ;
        $query_image = 'select * from images_biens_immobiliers where id_bien = :id ' ;
        $query_image = $db->prepare($query_image) ;
        $query_image->execute([':id' => $result['id']]) ;
        ?>
        <div class='cont_annonce'>
          <div class='img_bx'>
            <!-- si il n'y a pas d'images associés à l'annonce on met l'image par défaut !-->
            <?php if ($query_image && !$query_image->rowCount()) :?>
              <img src='images_annonces/no_photo.jpg' alt='photo indisponible'>
            <!-- sinon on affiche la première image obtenu en resultat !-->
            <?php else : ?>
              <img src=<?php echo 'images_annonces/' . $query_image->fetch()['nom_image'] ; ?> alt='photo indisponible'>
            <?php endif ; ?>
          </div>
          <div class='cont_descr'>
            <p>
            <strong>type de bien :</strong> <?php echo $result['type'] . '<br>';?>
            <strong>Description :</strong> 
            <?php echo '<br>' . $result['description'] ; ?> 
            </p>
            <p class='prix'>
            <strong>Prix de vente :</strong> <?php echo $result['prix'] . '€' ; ?>
            </p>
          </div>
        </div>
    <?php } ?>

    <?php /* inclut le même footer pour la page louer.php et acheter.php */ 
      include('footer.php') ;
    ?>

  </body>

</html>