<?php
session_start() ;

  include("connexion.php");
  include("function.php") ;

  if(isset($_POST['submit']) && $_POST['submit'] == 'signup'){
    // something was posted
    $nom = $_POST["nom"] ;
    $prenom = $_POST["prenom"] ;
    $numero = $_POST["numero"] ;
    $username = $_POST['username'] ;
    $password = $_POST['password'] ;
    $password_rep = $_POST['password_repeat'] ;
    
    if ( !invalid_informations($prenom, $nom, $numero, $username,$password, $password_rep) ){
      if (!invalid_name($nom) || !invalid_name($prenom)){
        if (!invalid_phone_number($numero)){
          if ( !invalid_username($username)){
            // on vérifie si le nom d'utilisateur n'existe pas déja dans la base d'utilisateur
            $db = connect() ;
            $query = 'select * from users WHERE user_name = :username' ;
            $query = $db->prepare($query) ;
            $query->execute([':username'=>$username ]) ;
            if ($query->rowCount() > 0){
              echo "Nom d'utilisateur déjà pris , veuillez choisir un autre !" ;
            }
            $query = 'select * from users WHERE number = :numero' ;
            $query = $db->prepare($query) ;
            $query->execute([':numero'=>$numero ]) ;
            if ($query->rowCount() > 0){
              echo "Numéro de téléphone déjà pris , veuillez choisir un autre !" ;
            }
            // sinon on vérifie si les deux mots passe sont identiques avant de les ajouter dans la base de données
            elseif (!not_match($password,$password_rep)){
              // sauvegarder les informations dans la base de données
              // on encrypte le mot de passe avant de l'ajouter à la base de données
              $password_encr = password_hash($password, PASSWORD_DEFAULT) ;
              $db = connect() ;
              $query = 'insert into users (id, user_name, password, nom, prenom, number) 
                        values ( NULL , :username , :password, :nom, :prenom, :number )' ;
              $query = $db->prepare($query) ;
              $query->execute([':username' => $username , ':password' => $password_encr, ':nom' => $nom, ':prenom' => $prenom, ':number' => $numero]) ;

              header("Location: login.php") ;
            }
            else{
              echo "Mots de passe non identiques !" ;
            }
          }
          else{
            echo "Nom d'utilisateur non valide !" ;
          }
        }
        else{
          echo "Numéro de téléphone non valide !" ;
        }
      }
      else{
        echo "Nom ou prénom non valide !" ;
      }
    }
    else{
      echo "Informations invalides !" ;
    }
  }

?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="style_login.css">
  <link rel="shortcut icon" href="images/ImmoHomeLogo.webp">
  <title>ImmoHome</title>
</head>

<body>
  <div class="box">
    <h2>Inscription</h2>
    <p>Créer votre compte pour accéder aux fonctionnalités de notre site !</p>
    <form method="post">
      <label><h3>Nom</h3></label>
      <div class="txt_field">
        <input id="text" type="text" name="nom">
      </div>
      <label><h3>Prénom</h3></label>
      <div class="txt_field">
        <input id="text" type="text" name="prenom">
      </div>
      <label><h3>Numéro de téléphone</h3></label>
      <h4>format : 0[6-7]00112233</h4>
      <div class="txt_field">
        <input id="text" type="tel" pattern="0[6-7]{1}[0-9]{8}" name="numero">
      </div>
      <label><h3>Nom d'utilisateur</h3></label>
      <div class="txt_field">
        <input id="text" type="text" name="username">
      </div>
      <label><h3>Mot de passe</h3></label>
      <div class="txt_field">
        <input id="text" type="password" name="password" >
      </div>
      <label><h3>Confirmer le mot de passe</h3></label>
      <div class="txt_field">
        <input id="text" type="password" name="password_repeat">
      </div>
      <br><br>
      <button type="submit" name="submit" value="signup">S'inscrire</button>
      <br><br>
      <a href="login.php">S'identifier</a>
    </form>
  </div>

</body>

</html>