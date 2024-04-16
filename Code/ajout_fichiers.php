<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur_connecte'])) {
    header("Location: index.php"); // Rediriger vers la page de connexion
    exit();
}

// Déconnexion de l'utilisateur
if (isset($_GET['deconnexion'])) {
    // Détruire la session
    session_destroy();
    // Rediriger vers la page d'accueil
    header("Location: index.php");
    exit();
}

?>


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

    <title>Page d'ajout des fichiers à la base de données</title>
</head>

<body>

<!--- Bandeau de navigation --->
<div class="container">
    <header class="d-flex justify-content-center py-3">
        <div>
        <img id="logo" src="media/e-calm-logo.png" alt="logo">
        <ul class="nav nav-pills">
            <li class="nav-tabs"><a href="recherche.php" class="nav-link">Recherche</a></li>
            <li class="nav-tabs"><a href="ajout_fichiers.php" class="nav-link active nav-color">Ajout</a></li>
            <li class="nav-tabs"><a href="gestion_fichiers.php" class="nav-link">Tableau de bord</a></li>
            <li class="nav-tabs"><a href="https://e-calm.huma-num.fr" target="_blank" class="nav-link">Projet E-Calm</a></li>
        </ul>
        </div>
      <?php include "bouton_deconnexion.php"; ?>  
  </header>
</div>

<!--- Boîte modale d'accueil --->
<div class="modal" id="welcomeModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center">Cette page permet d'ajouter des fichiers à la base de données.</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">x</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Afin qu'ils soient correctement ajoutés, veuillez respecter les indications données concernant les formats et noms.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-perso" data-dismiss="modal">Continuer</button>
      </div>
    </div>
  </div>
</div>


<div class="container mt-5">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <form id="uploadForm" enctype="multipart/form-data">
                <div class="form-group">
                    <strong><label for="file">Choisissez les fichiers à télécharger (formats .xml et .jpg attendus)</label></strong>
                    <input class="form-control-file" type="file" name="file[]" id="file" multiple>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary btn-sm" type="button" id="cancelBtn">Annuler la sélection</button>
                    </div>
                </div>
                <div id="fileList" class="alert alert-info" role="alert"><div class="text-center"><strong>ATTENTION</strong></div> <div class="text-justify">Pour associer un fichier .xml et le scan de la copie (.jpg), il faut impérativement qu'ils portent le même nom (extension et numéro de scan exlus). <br> Exemple : <i>EC-CE1-2014-ABZ1-D1-E1-V1.xml</i> et <i>EC-CE1-2014-ABZ1-D1-E1-V1-001.jpg</i><br> Le scan est obligatoire.</div></div>
                <div class="d-flex justify-content-center">
                <button id="submitBtn" class="btn btn-perso" type="button">Ajouter les fichiers sélectionnés</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Boîte modale pour afficher la réponse du script PHP -->
<div class="modal" id="responseModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center">Réponse du serveur</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Emplacement pour afficher la réponse du script PHP -->
        <p id="responseText"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>


<script>
    $(document).ready(function(){
        $('#welcomeModal').modal('show');
      });

    $(document).ready(function() {
        // Lorsque le bouton de soumission est cliqué
        $('#submitBtn').click(function() {
            // Créer un objet FormData pour les données du formulaire
            var formData = new FormData($('#uploadForm')[0]);

            // Effectuer une requête AJAX vers le script PHP
            $.ajax({
                url: 'traitement.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    // Afficher la réponse dans la nouvelle boîte modale
                    $('#responseText').text(response);
                    $('#responseModal').modal('show'); // Afficher la boîte modale
                }

            });
        });

        // Utiliser jQuery pour détecter les changements dans le champ de fichier
        $('#file').change(function() {
            // Réinitialiser la liste des fichiers
            $('#fileList').empty();        
            // Parcourir les fichiers sélectionnés
            $.each(this.files, function(index, file) {
                // Créer un élément de liste pour chaque fichier et l'ajouter au conteneur
                $('#fileList').append($('<div>').text(file.name));
            });
        });
    });

    // L'utilisateur peut annuler la sélection de fichier en cas d'erreur
    $(document).ready(function() {
            // Lorsque le bouton "Annuler la sélection" est cliqué
            $('#cancelBtn').click(function() {
                // Réinitialiser le champ de fichier pour effacer la sélection
                $('#file').val('');
                // Réafficher le message d'information
                $('#fileList').html('<div class="text-center"><strong>ATTENTION</strong></div><div class="text-justify">Pour associer un fichier .xml et le scan de la copie (.jpg), il faut IMPÉRATIVEMENT qu\'ils portent le même nom (extension exclue). <br> Exemple : <i>nom_du_fichier.xml</i> et <i>nom_du_fichier.jpg</i><br> Le scan n\'est pas obligatoire.</div>');
            });
        });


</script>
</body>
</html>