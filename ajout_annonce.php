<?php
session_start() ;
include("connexion.php") ;
include("function.php") ;

if (!isset($_SESSION['user_id'])){
    header('Location: login.php') ;
    die ;
}

$pdo = connect() ;

$submit1 = 0 ;
/* vérifier le formulaire avant d'insérer les informations dans la base de données*/
formulaire_annonce() ;

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
    
    <a href="index.php"><button>Accueil</button></a> 

    <?php if (! $submit1) : ?>
    <form id="annonce" method="post" enctype="multipart/form-data">
        <label>Type :</label>
        <select name="type" value="appartement" >
            <option name="type" value="appartement">Appartement</option>
            <option name="type" value="maison">Maison</option>
            <option name="type" value="parking">Parking</option>
            <option name="type" value="Terrain">Terrain</option>
        </select>
        <br>
        <label>Ville : </label>
        <?php 
            /* affiche tous les villes disponibles dans la base de données */
            $query = 'SELECT * FROM ville ORDER BY id ' ;
            $query = $pdo->prepare($query) ;
            $query->execute() ;
            //echo $query->rowCount() ;
            $resultats = $query->fetchALL() ;
            echo '<select name="ville" value=' . $resultats[0]['id'] . '>' ;
            foreach($resultats as $resultat){
            echo '<option name="ville" value='. $resultat['id'] . '>' . $resultat['nom_ville'] . ' ' . $resultat['code_postal'] . '</option>' ;
            } ?>
        </select>
        <br>
        <label>Surface :</label>
        <input type="text" name="surface">
        <br>
        <label> Description : </label><br>
        <textarea rows=10 cols=50 type="text" name="description" placeholder='facultatif (recommandé) '></textarea>
        <!-- <input type="text" name="description"> !-->
        <br>
        
        <label> Images : </label>
        <input type="file" name="image[]" accept="image/jpg, image/jpeg, image/png" multiple>

        <label> Votre bien est à </label>
        <input type="radio" id="acheter" name="choix" value="acheter"><label>acheter</label>
        <input type="radio" id="louer" name="choix" value="louer"><label>louer</label>
        <br>
        
    </form>
    <?php endif ;?>
    
    <?php 
        /* affiche les infos entrées
        echo '<br> type ' . $type . '<br>' ;
        echo 'ville ' . $ville . '<br>' ;
        echo 'surface = '.$surface . '<br>' ;
        echo 'description ' . $description . '<br>' ;
        */
    ?> 

    <script>
        let acheterBtn = document.getElementById("acheter") ;
        let louerBtn = document.getElementById("louer") ;
        let form = document.getElementById("annonce") ;

        acheterBtn.addEventListener("click", function() {
            console.log("acheter est cliqué") ;

            depot = document.getElementById("depot") ;
            prix = document.getElementById("prix") ;
            enregistrer = document.getElementById("Enregistrer") ;

            if (enregistrer != null)
                enregistrer.parentNode.removeChild(enregistrer) ;
            if (depot != null)
                depot.parentNode.removeChild(depot) ;
            if (prix != null)
                prix.parentNode.removeChild(prix) ;

            let prixInput = document.createElement("input");
            prixInput.setAttribute("type", "text");
            prixInput.setAttribute("name", "prix");
            prixInput.setAttribute("id", "prix");
            prixInput.setAttribute("placeholder", "Prix d'achat");

            form.appendChild(prixInput);

            let enregistrerButton = document.createElement("button") ;
            enregistrerButton.innerHTML = "Enregistrer" ;
            enregistrerButton.setAttribute("type", "submit") ;
            enregistrerButton.setAttribute("name", "submit1") ;
            enregistrerButton.setAttribute("id", "Enregistrer") ;
            enregistrerButton.setAttribute("value", "Enregistrer") ;

            form.appendChild(enregistrerButton) ;
        });

        louerBtn.addEventListener("click", function() {

            enregistrer = document.getElementById("Enregistrer") ;
            if (enregistrer != null)
                enregistrer.parentNode.removeChild(enregistrer) ;
            prix = document.getElementById("prix") ;
            if (prix != null)
                prix.parentNode.removeChild(prix) ;

            let depotInput = document.createElement("input");
            depotInput.setAttribute("type", "text");
            depotInput.setAttribute("name", "depot");
            depotInput.setAttribute("id", "depot");
            depotInput.setAttribute("placeholder", "Dépôt de garantie");

            let prixInput = document.createElement("input");
            prixInput.setAttribute("type", "text");
            prixInput.setAttribute("name", "prix");
            prixInput.setAttribute("id", "prix");
            prixInput.setAttribute("placeholder", "Prix de location");

            form.appendChild(depotInput);
            form.appendChild(prixInput);

            let enregistrerButton = document.createElement("button") ;
            enregistrerButton.innerHTML = "Enregistrer" ;
            enregistrerButton.setAttribute("type", "submit") ;
            enregistrerButton.setAttribute("name", "submit1") ;
            enregistrerButton.setAttribute("id", "Enregistrer") ;
            enregistrerButton.setAttribute("value", "Enregistrer") ;

            form.appendChild(enregistrerButton) ;
        });
    </script>

</body>

<?php $pdo = null ;?>

<html>
