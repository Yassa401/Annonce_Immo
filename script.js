const images = [
    "url(images/img_principale.jpg) no-repeat center/cover",
    "url(images/cuisine.jpg) no-repeat center/cover",
    "url(images/chambre.jpg) no-repeat center/cover",
    "url(images/salon.jpg) no-repeat center/cover"
];

let variable = 0;
let btnGauche = document.getElementById("btn-gauche");
let btnDroite = document.getElementById("btn-droite");

console.log(document.URL);
if(document.URL == "index.php"){
  let style = document.querySelector('.contenu').style;
}


if(btnGauche != null && btnGauche != undefined){
btnGauche.addEventListener("click", ()=> {
    variable -=1;
    if (variable < 0) {
        variable = (images.length) - 1;
    }
    if(style != null && style != undefined)
      style.setProperty('--background', images[variable]);
});
}

if(btnDroite != null && btnDroite != undefined){
btnDroite.addEventListener("click", ()=> {
    variable +=1;
    if (variable > (images.length) - 1) {
        variable = 0;
    }
    if(style != null && style != undefined)
      style.setProperty('--background', images[variable]);
});
}

// Récupère l'élément "user" et le menu utilisateur
const userElement = document.getElementById('user');
const userMenu = document.getElementById('menu-utilisateur');

userElement.addEventListener('click', () => {
  // Affiche ou masque le menu utilisateur en fonction de son état actuel
  if(userMenu.style.display == 'none'){
    //userElement.style.backgroundColor = '#1a3e81';
    userMenu.style.display = 'block';
  }
  else{
    //userElement.style.backgroundColor = inherit;
    userMenu.style.display = 'none';
  }
});


function boutonClique(bouton) {
    if(bouton.id == "acheter"){
      document.getElementById(bouton.id).style.color = "#363da6";
      document.getElementById(bouton.id).style.background = "white";
      document.getElementById("louer").style.color = "white";
      document.getElementById("louer").style.background = "#363da6";
    }
    else{
      if(bouton.id == "louer"){
        document.getElementById(bouton.id).style.color = "#363da6";
        document.getElementById(bouton.id).style.background = "white";
        document.getElementById("acheter").style.color = "white";
        document.getElementById("acheter").style.background = "#363da6";
      }
    }
      document.getElementById('choix').value=bouton.id;
    console.log("bouton cliqué") ;
}

function boutonTrie(bouton){
  if(bouton.id == "drop_menu_trie"){
    element = document.getElementById("trie_champ") ;
    if(element.style.display == "none"){
      element.style.display = "block";
      elementform.style.display = "block";
    }
    else{
      element.style.display = "none";
    }  
  }
  if(bouton.name == "date"){
    document.getElementById('champDate').value = document.getElementById(bouton.id).value;
  }
}

function switchImage(){
    variable -= 1;
    if(variable < 0) {
      variable = (images.length) - 1;
    }
    style.setProperty('--background', images[variable]);
}
