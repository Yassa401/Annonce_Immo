<?php
session_start() ;
    include("connexion.php") ;
    include("function.php") ;

    $user_data = check_login() ;

    if (isset ($_GET['rech_btn']) && $_GET['rech_btn'] == 'rechercher'){

        if (isset($_GET['type']) && isset($_GET['ville'])) {
            $type = $_GET['type'];
            $ville = $_GET['ville'];
        
            $prix_min = null ;
            $prix_max = null ;
            $surface_min = null ;
            $surface_max = null ;

            if (isset($_GET['prix_min']) && is_numeric($_GET['prix_min']))
                $prix_min = intval($_GET['prix_min']) ;
            if (isset($_GET['prix_max']) && is_numeric($_GET['prix_max']))
                $prix_max = intval($_GET['prix_max']) ;
            if (isset($_GET['surface_min']) && is_numeric($_GET['surface_min']) )
                $surface_min = intval($_GET['surface_min']) ;
            if (isset($_GET['surface_max']) && is_numeric($_GET['surface_max']))
                $surface_max = intval($_GET['surface_max']) ;  
            
        }
        if(isset($_GET['choix'])){
            if ($_GET['choix'] == "acheter"){
                header('Location: acheter.php?type=' . $type . '&ville=' . $ville . '&prix_min=' . $prix_min . '&prix_max=' . $prix_max . '&surface_min=' . $surface_min . '&surface_max=' . $surface_max ) ;
                    exit();
            }
            if ($_GET['choix'] == "louer"){
                header('Location: louer.php?type=' . $type . '&ville=' . $ville . '&prix_min=' . $prix_min . '&prix_max=' . $prix_max . '&surface_min=' . $surface_min . '&surface_max=' . $surface_max);
                exit();
            }
        }
    }

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="style.css">
    <title>ImmoHome</title>
</head>

<body>
    <header>
        <?php include("header.php") ; ?> 
        <div class="contenu">
            
            <div class="illustre">
                 <h1>Demain<br> Commence Ici</h1>
                 <p>N'hesitez Plus,  Choissisez Votre Coup De Coeur</p>
            </div>
            <div class="swiper">
                <i class='bx bx-left-arrow-alt' id="btn-gauche"></i>
                <i class='bx bx-right-arrow-alt' id="btn-droite"></i>  
            </div>

        <form method="get">
            <!-- <div class="choix-client">
                <div class="btn_haut">
                    <button type="button" id="acheter" onclick="boutonClique(this)" name="page" value="acheter" >Acheter</button>    
                    <button type="button" id="louer" onclick="boutonClique(this)" name="page" value="louer">Louer</button>
                    <input type="hidden" name="choix"  id="choix" value=""> 
                </div>
        <div class="parent">
                <div class="selection auto-height">
                  
                
                        <div class="info">
                            <h4 class="titre">Où Cherchez-Vous ?</h4>
                            <h5 class="loc">LOCALITÉS</h5>
                            <?php 
                                $pdo = connect() ;
                                /* affiche tous les villes disponibles dans la base de données */
                                $query = 'SELECT * FROM ville ORDER BY id ' ;
                                $query = $pdo->prepare($query) ;
                                $query->execute() ;
                                //echo $query->rowCount() ;
                                $resultats = $query->fetchALL() ;
                                echo '<select name="ville" value=' . $resultats[0]['id'] . '>' ;
                                foreach($resultats as $resultat){
                                echo '<option name="ville" value='. $resultat['id'] . '>' . $resultat['nom_ville'] . ' ' . $resultat['code_postal'] . '</option>' ;
                                }
                            ?>
                            </select>
                            <h5 class="type-biens">TYPE DE BIENS</h5>  
                            <select name="type" id="type">
                                <option value="appartement">Appartement</option>
                                <option value="maison">Maison</option>
                                <option value="terrain">Terrain</option>
                                <option value="parking">Parking</option>
                            </select><br><br> 
                         </div>
                        <div class="info"> 
                             <h5 class="budget">BUDGET</h5>
                            <input class="text3" type="text" name="prix_min" placeholder="Min"></input>
                            <input class="text3" type="text" name="prix_max" placeholder="Max"></input>
                        </div>
                        <div class="info"> 
                            <h5 class="surface">SURFACE</h5>
                           <input class="text4" type="text" name="surface_min" placeholder="Min"></input>
                           <input class="text4" type="text" name="surface_min" placeholder="Max"></input>
                       </div>
                        <div class="rechercher_btn">
                             <i class='bx bx-search-alt'></i> 
                            <button id="rech_btn" name="rech_btn" class="rechercher_btn" type="submit" value="rechercher"> Rechercher</button>
                           
                        </div>
                
            </div>  
        </div> -->
        </form>
    </header>

    <div class="main_bas"> 
        <div class="titre_main" id="actualite">
          <h2>EXPLOREZ NOS ACTUALITES</h2> 
          <button>Voir Plus <i class='bx bx-arrow-to-right'></i></button> 
          
        </div>

    </div>

    <div class="main_img">
        <?php 
        $query = "SELECT * FROM biens_immobiliers, images_biens_immobiliers, ville
                  WHERE biens_immobiliers.id = images_biens_immobiliers.id_bien
                  AND biens_immobiliers.id_ville = ville.id
                  ORDER BY biens_immobiliers.id DESC
                  LIMIT 5 " ;
        $query = $pdo->prepare($query) ;
        $query->execute() ;
        
        $resultats = $query->fetchAll() ;

        foreach($resultats as $resultat){ ?>
        <div class="carton">
            
            <img src=<?php echo "images_annonces/" . $resultat['nom_image'] ; ?> alt="image1"> 
            <div class="conten_haut">
                <div class="description">
                    <h4><?php echo $resultat['type'] ; ?></h4>
                    <p><?php echo $resultat['nom_ville'] ;?></p>
                </div>
            </div>
        </div>

        <?php } ?>
    </div>
<section>
   <h2>Pourquoi Nous Choisir</h2>
   <div class="box">
        <div class="img_bx">
              <img src="images/ste_img.png" alt="image de carte"> 
    </div>
    <div class="cont_box">
        <h6><span>Notre devise</span></h6>
        <h1>Votre Confort <br> Notre TOP Priorité</h1>
        <p>Pour acheter comme pour louer, nous nous sommes dit que la recherche immobilière était souvent compliquée. Après tout, trouver un logement, ce n’est pas juste trouver quatre murs, c’est aussi trouver la réponse à ses besoins et à son style de vie. C’est pour cette raison que nous avons décidé de créer ImmoHome, le premier moteur de recherche immobilière qui prend en compte le logement en lui-même mais aussi ses alentours avec la vie de quartier et les points d’intérêt à proximité.</p>
        <ul>
            <li>Temoignages Clients</li>
            <li>Espace Presse</li>
            <li>Alerte Mail</li>
            <li>Nous Contacter</li>
        </ul>
    </div>
</div>

<?php include("footer.php") ; ?>

</section>

<script src="script.js">setInterval(switchImage(),1000);</script>

</body>
</html>