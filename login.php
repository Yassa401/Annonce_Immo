<?php
session_start() ;

include("connexion.php");
include("function.php") ;

if(isset($_POST['submit']) && $_POST['submit'] == 'login'){
  // quelque chose a été posté 
  $username = $_POST['username'] ;
  $password = $_POST['password'] ;
  
  if (!empty($username) && !empty($password) && !is_numeric($username)){
    // lire de la base de donnee
    $db = connect() ;
    $query = 'select * from users where user_name = :username limit 1' ;
    $query = $db->prepare($query) ;
    $query->execute([':username' => $username]) ;
    
    if ($query){
      if ($query && ($query->rowCount() > 0)){
        
        $user_data = $query->fetch() ;
        /* on compare le mot de passe entré avec celui encrypté dans la base de données */
        if (password_verify($password, $user_data['password'])){
          $_SESSION['user_id'] = $user_data['id'] ;
          header("Location: index.php") ;
        }
      }
    }   
    echo "identifiant ou mot de passe incorrect!" ;
  } 
  else{
    echo "Informations invalides !" ;
  }
 
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ImmoHome</title>
  <link rel="stylesheet" href="style_login.css">
</head>

<body>
  <div class="box">
    <h2>Bonjour</h2>
    <p>connectez-vous pour avoir accès aux nouvelles fonctionnalités !</p>
    <form method="post">
      <label><h3>Nom d'utilisateur</h3><label>
        <div class="txt_field">
          <input id="text" type="text" name="username" >
        </div>
      <br><br>
      <label><h3>Mot de passe</h3><label> 
        <div class="txt_field">
          <input id="text" type="password" name="password" >
        </div>
      <br><br>
      <button type="submit" name="submit" value="login">Se connecter</button>
      <br><br>
      <a href="signup.php">Créer un compte</a>
    </form>
  </div>

</body>

</html>