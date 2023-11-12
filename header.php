
<nav>
    <a href="#" class="logo">ImmoHome </a>     
    <div class="elements">
        <ul>
            <div class="btn_haut"><li><a href="ajout_annonce.php">Créer une annonce</a></li></div>
            <li><a href="index.php">ACCUEIL</a></li>
            <li><a href="acheter.php">ACHETER</a></li>
            <li><a href="louer.php">LOUER</a></li>
            <li><a href="#actualite">ACTUALITES</a></li> 
        </ul>
        <div class="account">
            <!-- si utilisateur connecté on affiche son nom et le lien pour se déconnecter !-->
            <?php if (isset($user_data)) :?>
                <h1 id="user"><?php echo $user_data['user_name'] ; ?></h1>
                <div id="menu-utilisateur">
                    <ul>
                        <li><a href="profil.php">Profil</a></li>
                        <li><a href="logout.php">Déconnexion</a></li>
                    </ul>
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