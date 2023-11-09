const images = [
    "url(images/img_principale.jpg) no-repeat center/cover",
    "url(images/cuisine.jpg) no-repeat center/cover",
    "url(images/chambre.jpg) no-repeat center/cover",
    "url(images/salon.jpg) no-repeat center/cover"
];

let variable = 0;

let btnGauche = document.getElementById('btn-gauche');
let btnDroite = document.getElementById('btn-droite');
let style = document.querySelector('.contenu').style;


btnGauche.addEventListener("click", ()=> {
    variable -=1;
    if (variable < 0) {
        variable = (images.length) - 1;
    }
   style.setProperty('--background', images[variable]);
});

btnDroite.addEventListener("click", ()=> {
    variable +=1;
    if (variable > (images.length) - 1) {
        variable = 0;
    }
   style.setProperty('--background', images[variable]);
});


// Récupère l'élément "user" et le menu utilisateur
const userElement = document.getElementById('user');
const userMenu = document.getElementById('menu-utilisateur');


userElement.addEventListener('click', () => {
  // Affiche ou masque le menu utilisateur en fonction de son état actuel
  if (userMenu.style.display === 'block') {
    userMenu.style.display = 'none';
  } else {
    userMenu.style.display = 'block';
  }
});




function boutonClique(bouton) {
    document.getElementById('choix').value=bouton.id;
    console.log("bouton cliqué") ;
}

