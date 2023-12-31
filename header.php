
<nav>
    <a href="#">
        <img class="logo" src="images/ImmoHomeLogo.webp" alt="ImmoHome" height="60px" width="100%">
    </a>     
    <div class="elements">
        <ul>
            <li><div class="btn_haut"><a href="ajout_annonce.php">Créer une annonce</a></div></li>
            <li><a href="index.php">ACCUEIL</a></li>
            <li><a href="acheter.php">ACHETER</a></li>
            <li><a href="louer.php">LOUER</a></li>
            <li><a href="actualites.php">ACTUALITES</a></li> 
        </ul>
        <div class="account">
            <!-- si utilisateur connecté on affiche son nom et le lien pour se déconnecter !-->
            <?php if (isset($user_data)) :?>
                <h1 id="user"><?php echo $user_data['user_name'] ; ?></h1>
                <div id="menu-utilisateur">
                    <div class="menu-content">
                        <div class="sds-container"></div>   
                    
                    <ul>
                        <li><a href="profil.php">Profil</a></li><hr>
                        <li><a href="logout.php">Déconnexion</a></li>
                    </ul>
                    </div>
                </div>
            <!-- sinon on afficher le lien pour se connecter !-->
            <?php else : ?>
                <a href="login.php">
                    <i class='bx bx-user'></i>
                </a>    
            <?php endif ; ?>
        </div>
    </div>
</nav>