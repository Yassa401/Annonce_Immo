<?php

session_start();
include('connexion.php');
include('function.php');

$user_data = check_login() ;

$user_id = $user_data["id"] ;

$db = connect() ;
$query = "SELECT number, nom, prenom FROM users WHERE id = :user_id";
$query = $db->prepare($query);
$query->execute([':user_id' => $user_id]);
$user = $query->fetch();

$number = $user['number'] ;
$nom = $user['nom'] ;
$prenom = $user['prenom'] ;

?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="style_annonce.css">
    <title>ImmoHome</title>
</head>
<body>
    <header>
        <?php include("header.php") ;?>
    </header>
    
    <div class="boxx">
        <img src="images/image_user.jpg" alt="image user">
        <h3>Mon Profil</h3>
        <p>Nom : <?php echo $nom ; ?></p>
        <p>Prénom : <?php echo $prenom ; ?></p>
        <p>Numéro de téléphone : <?php echo $number ; ?></p>
    </div>
    
    <h1>Liste des annonces</h1>
    <!-- <ul>
        <li>
            <a href="annonce.php?id=1">
                <img src="annonce1.jpg" alt="Annonce 1">
                <h2>Annonce 1</h2>
                <p>Description de l'annonce 1</p>
            </a>
        </li>
    </ul> !-->

    <?php 
    $db = connect() ;
    $query = "SELECT id_bien , prix, id_user, id_ville, surface, type, description 
            FROM biens_achat, biens_immobiliers
            WHERE biens_achat.id_bien = biens_immobiliers.id and id_user = :id_user" ;
    $query = $db->prepare($query) ;
    $query->execute([ ':id_user'=>$user_id ]) ;
    for($i=0 ; $i<$query->rowCount() ; $i++){
        $result = $query->fetch() ;
        $query_image = 'select * from images_biens_immobiliers where id_bien = :id ' ;
        $query_image = $db->prepare($query_image) ;
        $query_image->execute([':id' => $result['id_bien']]) ;
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
      <a href="suppression_annonce.php?id=<?php echo $result['id_bien'] ; ?>"><button>Supprimer</button></a>
    <?php } ?>

    <?php 
    $db = connect() ;
    $query = "SELECT id_bien, prix, depot_garantie, id_user, id_ville, surface, type, description 
            FROM biens_location, biens_immobiliers
            WHERE biens_location.id_bien = biens_immobiliers.id AND id_user = :id_user" ;
    $query = $db->prepare($query) ;
    $query->execute([':id_user' => $user_id]) ;
    for($i=0 ; $i<$query->rowCount() ; $i++){
        $result = $query->fetch() ;
        $query_image = 'select * from images_biens_immobiliers where id_bien = :id ' ;
        $query_image = $db->prepare($query_image) ;
        $query_image->execute([':id' => $result['id_bien']]) ;
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
            <span class="description"><?php echo '<br>' . $result['description'] ; ?> </span> 
            </p>
            <p class='prix'>
            <strong>Depôt de garantie :</strong> <?php echo $result['depot_garantie'] . '€ <br>' ; ?>
            <strong>Prix location :</strong> <?php echo $result['prix'] . '€' ; ?>
            </p>
          </div>
        </div>
      <a href="suppression_annonce.php?id=<?php echo $result['id_bien'] ; ?>"><button>Supprimer</button></a>
    <?php } ?>

	<?php include("footer.php") ; ?>
	
  <script src="script.js"></script>

</body>
</html>
