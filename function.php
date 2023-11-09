<?php

function check_login(){
    if ( isset($_SESSION['user_id'] ) ){
        $id = $_SESSION['user_id'] ;
        $db = connect() ;
        $query = 'select * from users where id = :id limit 1' ;
        $query = $db->prepare($query) ;
        $query->execute([':id' => $id]) ;
    
        if ($query){
            if ($query && ($query->rowCount() > 0)){
                $user_data = $query->fetch() ;
                return $user_data ;
            }
        }
    }
    return null ;
} 
function invalid_informations($prenom, $nom, $numero, $username, $password, $password_rep){
    $result = false ;
    /* pour verifier que tout le formulaire etait rempli */
    if ( empty($username) || empty($password) || empty($password_rep) || empty($prenom) || empty($nom) || empty($numero)){
        $result = true ;
    }

    return $result ;
}

function invalid_name($nom){
    $result = false ;
    /* to test if username have these characters */
    if (!preg_match("/^[a-zA-Z]*$/",$nom)) {
        $result = true ;
    }

    return $result ;

}

function invalid_phone_number($numero){
    $result = false ;
    /* to test if username have these characters */
    if (!preg_match("/^[0-9]{10}$/",$numero)) {
        $result = true ;
    }

    return $result ;
}

function invalid_username($username){
    $result = false ;
    /* to test if username have these characters */
    if (!preg_match("/^[a-zA-Z0-9]*$/",$username)) {
        $result = true ;
    }

    return $result ;
}

// test si les deux mots de passe sont identiques 
function not_match($password, $password_rep){
    $result = false ;
    if ( $password !== $password_rep){
        $result = true ;
    }
    return $result ;
}


function formulaire_annonce(){
    $pdo = connect() ;

    /* Envoi du formulaire 1 */
    $type = 'appartement' ;
    $ville = 1 ;
    $surface = 0 ;
    $description = '' ;
    /* Envoi du formulaire 1 */
    $prix = 0 ;
    $depot = 0 ;

    /* variables pour verifier si les donnees ont été bien enregistrees */
    $submit1 = 0 ; // verifie si les infos générales sont enregistrées dans biens_immobiliers
    $submit2 = 0 ; // verifie s'ils sont enregistrées soit dans biens_location ou biens_achat
    $submit3 = 0 ; // verifie si les infos sur les images sont enregistrées dans images_biens_immobiliers



    if (isset($_POST['submit1']) && isset($_POST['submit1']) == 'Enregistrer'){
        /* verifier que les informations entrées sont valides*/ 
        if (isset($_POST['type']) && isset($_POST['ville']) 
        && isset($_POST['surface']) && is_numeric($_POST['surface'])){
            $type = $_POST['type'] ;
            $ville = $_POST['ville'] ;
            $surface = intval($_POST['surface']) ;
    
            if (!empty($_POST['description'])){
                $description = filter_input(INPUT_POST, 'description' , FILTER_SANITIZE_SPECIAL_CHARS) ;
            }
    
            $query = 'INSERT INTO biens_immobiliers (id, id_user, id_ville, surface, type, description)
                      VALUES (NULL, :id_user, :id_ville, :surface, :type, :description)' ;
            $query = $pdo->prepare($query) ;
            $query->execute([':id_user'=> $_SESSION['user_id'], ':id_ville' => $ville, ':surface' => $surface, 
                                    ':type'=>$type, ':description'=>$description ]) ;
                
            $id_insere = $pdo->lastInsertId() ;

            if ( count($_FILES["image"]["name"]) != 0 ){
                if($_FILES["image"]["error"][0] == UPLOAD_ERR_OK){
                    $nom_image = $_FILES["image"]["name"][0] ;
                    $tmp_nom_image = $_FILES["image"]["tmp_name"][0] ;
                    $query = 'INSERT INTO images_biens_immobiliers (id_bien , nom_image) VALUES (:id_bien, :nom_image)' ;
                    $query = $pdo->prepare($query) ;
                    $query->execute([':id_bien' => $id_insere , ':nom_image' => $nom_image]) ;
                    move_uploaded_file($tmp_nom_image, "./images_annonces/$nom_image") ;
                    
                }
            }

            if (isset($_POST['choix']) && $_POST['choix'] === "acheter" && isset($_POST['prix']) && is_numeric($_POST['prix']) ){
                $prix = intval($_POST['prix']) ;
                $query = 'INSERT INTO biens_achat (id_bien , prix) VALUES (:id_bien, :prix)' ;
                    $query = $pdo->prepare($query) ;
                    $query->execute([':id_bien'=> $id_insere, ':prix' => $prix ] ) ;

                    echo "Annonce ajouté avec succès !<br>" ;
            }
            else {
                if (isset($_POST['choix']) && $_POST['choix'] === "louer" && isset($_POST['prix']) && isset($_POST['depot']) 
                && is_numeric($_POST['prix']) && is_numeric($_POST['depot']) ){
                    $prix = intval($_POST['prix']) ;
                    $depot = intval($_POST['depot']) ;
                    $query = 'INSERT INTO biens_location (id_bien , prix , depot_garantie)
                        VALUES (:id_bien, :prix, :depot)' ;
                    $query = $pdo->prepare($query) ;
                    $query->execute([':id_bien'=> $id_insere, ':prix' => $prix, ':depot' => $depot ] ) ;    
                    
                    echo "Annonce ajouté avec succès !<br>" ;
                }
                else{
                    $query = 'DELETE FROM biens_immobiliers WHERE id = :id_bien ' ;
                    $query = $pdo->prepare($query) ;
                    $query->execute([':id_bien'=> $id_insere ] ) ;
                    if (! (isset($_POST['choix']) ) )
                        echo "Veuillez choisir si vous voulez vendre ou louer votre bien <br>" ;
                    else{
                        if ( ! is_numeric($_POST['prix']))
                            echo 'Veuillez entrer une valeur numérique dans la rubrique prix <br>' ;
                        if (isset($_POST['depot'])){
                            if (! is_numeric($_POST['depot']))
                            echo 'Veuillez entrer une valeur numérique dans la rubrique depôt de garantie<br>' ;
                        }
                    }
                }
            }
        }
        else {
            if (!isset($_POST['type']))
                echo 'type n\'est pas défini <br>' ;
            if (!isset($_POST['surface']))
                echo 'surface n\'est pas défini <br>' ;
            if (!is_numeric($_POST['surface']))
                echo 'Veuillez entrer une valeur numérique dans la rubrique surface <br>' ;
            if (!isset($_POST['ville']))
                echo 'ville n\'est pas défini <br>' ;
            if (!isset($_POST['description']))
                echo 'description n\'est pas défini <br>' ;
        }
    }
}
