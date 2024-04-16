<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--- Feuilles de style --->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">

    <!--- Scripts JS et JQuery --->
    <script src="scripts/jquery-3.7.1.min.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

    <title>Page de recherche</title>
  </head>

<?php
session_start();

// Déconnexion de l'utilisateur
if (isset($_GET['deconnexion'])) {
    // Détruire la session
    session_destroy();
    // Rediriger vers la page d'accueil
    header("Location: index.php");
    exit();
}
?>

<body>
<!--- Bandeau de navigation --->
<div class="container">
  <header class="d-flex justify-content-center py-3">
    <div>
      <img id="logo" src="media/e-calm-logo.png" alt="logo">
      <ul class="nav nav-pills">
        <li class="nav-tabs"><a href="gestion_fichiers.php" class="nav-link">Tableau de bord</a></li>
        <li class="nav-tabs"><a href="recherche.php" class="nav-link active nav-color">Recherche</a></li>
        <li class="nav-tabs"><a href="https://e-calm.huma-num.fr" target="_blank" class="nav-link">Projet E-Calm</a></li>
      </ul>
    </div>
    <?php include "bouton_deconnexion.php"; ?>  
  </header>
</div>

<!--- Nom du fichier et corpus --->
<form class="container mt-5 mb-4" action="tableau_resultats.php" method="POST">
  <div class="row">
    <div class="row mt-2 mb-4">
      <div class="col-md-6">
        <strong><label for="fichier" class="form-label">Nom du fichier</label></strong>
        <input type="text" class="form-control" id="fichier" name="fichier" placeholder="Vous pouvez saisir le nom du fichier">
      </div> 

      <div class="col-md-6 color-row1">
        <div class="row">
          <strong><label for="corpus" class="form-label" style="margin-left: 10px;">Corpus</label></strong>
        </div>
        <div class="form-check form-check-inline" style="margin-left: 10px;">
          <input class="form-check-input" type="checkbox" id="scoledit" name="corpus[]" value="scoledit">
          <label class="form-check-label" for="scoledit">ScolEdit</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="ecriscol" name="corpus[]" value="ecriscol">
          <label class="form-check-label" for="ecriscol">Ecriscol</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="litteracie" name="corpus[]" value="litteracie">
          <label class="form-check-label" for="litteracie">Littéracie Avancée</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="resolco" name="corpus[]" value="resolco">
          <label class="form-check-label" for="resolco">RésolCo</label>
        </div>
      </div>
    </div>
  </div>

<!--- Nom de l'élève, classe, niveau et année --->
  <div class="row mt-3 mb-4 color-row2">
    <div class="col-md-3">
      <strong><label for="eleve" class="form-label">Élève</label></strong>
      <input type="text" class="form-control with-animation" id="eleve" name="eleve" placeholder="Vous pouvez saisir l'identifiant de l'élève">
    </div>

    <div class="col-md-3">
      <strong><label for="classe" class="form-label">Classe</label></strong>
      <input type="text" class="form-control" id="classe" name="classe" placeholder="Vous pouvez saisir la classe">
    </div>
    
    <div class="col-md-3">
      <strong><label class="form-label">Niveau</label></strong>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="tousNiveaux">
        <label class="form-check-label" for="selectTous">Tous les niveaux</label>
      </div>
      <select class="selectpicker" id="niveau" name="niveau[]" multiple data-live-search="true" data-none-selected-text="Aucune sélection">
        <option value="cp">CP</option>
        <option value="ce1">CE1</option>
        <option value="ce2">CE2</option>
        <option value="cm1">CM1</option>
        <option value="cm2">CM2</option>
        <option value="6">6ème</option>
        <option value="5">5ème</option>
        <option value="4">4ème</option>
        <option value="3">3ème</option>
        <option value="2">Seconde</option>
        <option value="1">Première</option>
        <option value="T">Terminale</option>
        <option value="univ">Université</option>
      </select>
    </div>

<script>
document.getElementById("tousNiveaux").addEventListener("click", function() {
   const selectpicker = document.getElementById("niveau");
   const options = selectpicker.options;

   if (this.checked) {
       for (let i = 0; i < options.length; i++) {
           options[i].selected = true;
       }
   } else {
       for (let i = 0; i < options.length; i++) {
           options[i].selected = false;
       }
   }
   selectpicker.dispatchEvent(new Event('change'));
   selectpicker.selectpicker('refresh');
});
</script>

    <div class="col-md-3">
      <strong><label class="form-label">Année</label></strong>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="toutesAnnees">
        <label class="form-check-label" for="selectTous">
            Toutes les années
        </label>
      </div>
      <select class="selectpicker" id="annee" name="annee[]" multiple data-live-search="true" data-none-selected-text="Aucune sélection">
        <option value="2014">2014</option>
        <option value="2015">2015</option>
        <option value="2016">2016</option>
        <option value="2017">2017</option>
      </select>
    </div>

<script>
document.getElementById("toutesAnnees").addEventListener("click", function() {
   const selectpicker = document.getElementById("annee");
   const options = selectpicker.options;

   if (this.checked) {
       for (let i = 0; i < options.length; i++) {
           options[i].selected = true;
       }
   } else {
       for (let i = 0; i < options.length; i++) {
           options[i].selected = false;
       }
   }
   selectpicker.dispatchEvent(new Event('change'));
   selectpicker.selectpicker('refresh');
});
</script>
  </div>

<!--- Normalisation, commentaires, longueur et taux d'erreur --->
  <div class="row mt-3 mb-4 color-row3">
    <div class="col-md-3">
      <div class="row">
        <strong><label for="normalisation" class="form-label" style="margin-left: 50px;" data-toggle="tooltip" title='Une normalisation linguistique a été ajoutée à certains textes. Si vous choisissez "Oui", vous pourrez visualiser la transcription du texte initial et sa version normalisée.'>Normalisation</label></strong>
      </div>
      <div class="form-check form-check-inline" style="margin-left: 50px;">
        <input class="form-check-input" type="radio" id="norm" name="normalisation" value="1">
        <label class="form-check-label" for="norm">Oui</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" id="no-norm" name="normalisation" value="0">
        <label class="form-check-label" for="no-norm">Non</label>
      </div>
    </div>

    <div class="col-md-3">
      <div class="row">
        <strong><label for="commentaires" class="form-label" data-toggle="tooltip" title="Ajouts effectués par l'élève et/ou commentaires de l'enseignant.">Commentaires</label></strong>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="com-eleve" name="commentaires[]" value="E">
        <label class="form-check-label" for="com-eleve">Élève</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="com-prof" name="commentaires[]" value="P">
        <label class="form-check-label" for="com-prof">Professeur</label>
      </div>
    </div>

    <div class="col-md-3">
      <div class="row">
        <strong><label for="longueur" class="form-label" data-toggle="tooltip" title="Concerne la longueur du texte. Court = moins de 50 mots. Moyen = entre 50 et 150 mots. Long = plus de 150 mots.">Longueur du texte</label></strong>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="court" value="C" name="longueur[]" disabled>
        <label class="form-check-label" for="court">Court</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="moyen" value="M" name="longueur[]" disabled>
        <label class="form-check-label" for="moyen">Moyen</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="long" value="L" name="longueur[]" disabled>
        <label class="form-check-label" for="long">Long</label>
      </div>
    </div>

    <div class="col-md-3">
      <div class="row">
        <strong><label for="erreur" class="form-label" data-toggle="tooltip" title="Si la normalisation a été effectuée, un taux d'erreur entre l'écrit de l'élève et la version normalisée est calculé.">Taux d'erreur</label></strong>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" id="sup-50" value=">50" name="erreur" disabled>
        <label class="form-check-label" for="sup-50">>= 50%</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" id="inf-50" value="<50" name="erreur" disabled>
        <label class="form-check-label" for="inf-50">< 50%</label>
      </div>
    </div>
  </div>

<!--- Version, temps d'écriture --->
  <div class="row mt-3 justify-content-center mb-4">
    <div class="col-md-2 color-row4-1">
      <div class="row">
        <strong><label for="version" class="form-label" style="margin-left: 20px;" data-toggle="tooltip" title="Pour la même consigne, l'élève a pu réaliser plusieurs copies.">Version</label></strong>
      </div>
      <div class="form-check form-check-inline" style="margin-left: 20px;">
        <input class="form-check-input" type="checkbox" id="v1" name="version[]" value="1">
        <label class="form-check-label" for="v1">1</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="v2" name="version[]" value="2">
        <label class="form-check-label" for="v2">2</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="v3" name="version[]" value="3">
        <label class="form-check-label" for="v3">3</label>
      </div>
    </div>

    <div class="col-md-3 color-row4-2">
      <div class="row">
        <strong><label for="temps" class="form-label" data-toggle="tooltip" title="Correspond au nombre de passages sur une copie. Par exemple, au T1 l'élève rédige, au T2 l'enseignant ajoute un commentaire, au T3 l'élève continue sa rédaction, etc.">Temps d'écriture</label></strong>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="t1" name="temps_ecriture[]" value="1">
        <label class="form-check-label" for="t1">1</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="t2" name="temps_ecriture[]" value="2">
        <label class="form-check-label" for="t2">2</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="t3" name="temps_ecriture[]" value="3">
        <label class="form-check-label" for="t3">3</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="t4" name="temps_ecriture[]" value="4">
        <label class="form-check-label" for="t4">4</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="t5" name="temps_ecriture[]" value="5">
        <label class="form-check-label" for="t5">5</label>
      </div>
    </div>

<!--- Recherche --->
    <div class="col-md-3 text-center">
      <div class="d-flex align-items-center justify-content-center" style="height: 100%;">
       <input type="submit" class="btn btn-perso btn-lg" name="ok" value="Lancer la recherche">
      </div>
    </div>
  </div>
</form>

<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});

  // Annulation de la sélection du bouton radio
  const radios = document.querySelectorAll('input[type="radio"]');
  let lastClickedRadio = null;
  function cancelSelection() {
    if (lastClickedRadio) {
      lastClickedRadio.checked = false; 
      lastClickedRadio = null; 
    }
  }
  radios.forEach(radio => {
    radio.addEventListener('click', function() {
      if (this === lastClickedRadio) {
        cancelSelection();
      } else {
        lastClickedRadio = this;
      }
    });
  });
  document.addEventListener('click', function(event) {
    const target = event.target;
    if (!target.closest('.form-check')) {
      cancelSelection();
    }
  });
</script>

</body>
</html>
