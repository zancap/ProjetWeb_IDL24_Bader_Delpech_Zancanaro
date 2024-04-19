<?php
session_start();

include "../modeles/recuperation_donnees_texte.php"; 

// Vérification si l'utilisateur clique sur "Tableau de bord"
if (isset($_GET['tableau_de_bord'])) {
    // Vérification si l'utilisateur n'est pas connecté
    if (!isset($_SESSION['utilisateur_connecte']) || $_SESSION['utilisateur_connecte'] !== true) {
        // Redirection vers la page de connexion
        header("Location: ../controleur/index.php");
        exit(); 
    } else {
        // Redirection vers la page de gestion des fichiers
        header("Location: ../modeles/gestion_fichiers.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--- Feuilles de style --->
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">

    <!--- Scripts JS et JQuery --->
    <script src="../scripts/jquery-3.7.1.min.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

    <title>Page de visualisation</title>
</head>
<body>

<!--- Bandeau de navigation --->
    <div class="container">
        <header class="d-flex justify-content-center py-3">
            <div>
            <img id="logo" src="../media/e-calm-logo.png" alt="logo">
            <ul class="nav nav-pills">
                <li class="nav-tabs"><a href="../vues/recherche.php" class="nav-link">Recherche</a></li>
                <li class="nav-tabs"><a href="../vues/affichage_texte.php" class="nav-link active nav-color">Fichier</a></li>
                <li class="nav-tabs"><a href="../vues/gestion_fichiers.php" class="nav-link">Tableau de bord</a></li>
                <li class="nav-tabs"><a href="https://e-calm.huma-num.fr" target="_blank" class="nav-link">Projet E-Calm</a></li>
            </ul>
            <?php include "../modeles/bouton_deconnexion.php"; ?>
            </div>
        </header>
    </div>

<!-- Récapitulatif des informations du fichier -->
    <div class="container-fluid">    
        <div class="row bg-light justify-content-center">
            <div class="col-md-6">
                <table class="table table-borderless text-center">
                    <tr>
                        <td>Nom</td>
                        <td>Niveau</td>
                        <td>Élève</td>
                        <td>Classe</td>
                        <td>Année</td>
                        <td>Corpus</td>
                        <td>Scan(s)</td>
                    </tr>
                    <tr>
                        <td><?php echo $id ?></td>
                        <td><?php echo $niveau ?></td>
                        <td><?php echo $eleve ?></td>
                        <td><?php echo $classe ?></td>
                        <td><?php echo $annee ?></td>
                        <td><?php echo $corpus ?></td>
                        <td><?php echo $nombre_scans ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Affichage de la transcription/normalisation et légende -->
    <div class="row mt-3">
      <div class="col-md-6" style="padding-left: 50px;">
        <div class="card">
          <div class="card-body text-center">
            <div style="white-space: nowrap;">
            <button class="btn btn-perso" id="btnTranscription">Transcription</button>
            <button class="btn btn-perso" id="btnNormalisation">Normalisation</button>
            </div>
            <div id="texte"><?php echo $texte ?></div>
          </div>
        </div>
        <div class="card mt-3">
          <div class="card-body">
            <h5 class="card-title">Légende</h5>
            <div class="row mt-3 justify-content-center">
                <div class="col-md-6">
                <p class="card-text"><span style="color: #AB9FFB"><s>Texte</s></span> : corrigé par l'élève.</p>
                <p class="card-text"><span style="color: #AB9FFB">Texte</span> : ajouté par l'élève.</p>
                </div>       
                <div class="col-md-6">
                <p class="card-text"><span style="color: red"><s>Texte</s></span> : corrigé par le professeur.</p>
                <p class="card-text"><span style="color: red">Texte</span> : ajouté par le professeur.</p>
                </div>
            </div>
          </div>
        </div>
      </div>

    <!-- Affichage du ou des scan(s) -->
    <div class="col-md-6">
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel" data-interval="false">
            <div class="carousel-inner">
                <?php
                // Utiliser une boucle pour afficher toutes les images associées à l'ID
                for ($i = 1; $i <= $nombre_scans; $i++) {
                    $image_path = "../uploads/{$id}-" . sprintf("%03d", $i); // Générer le chemin de l'image
                    ?>
                    <div class="carousel-item <?php echo $i === 1 ? 'active' : ''; ?>">
                        <h6 class="text-center">Scan <?php echo $i; ?></h6>
                        <p class="text-center"><i>Vous pouvez cliquer sur l'image pour l'agrandir.</i></p>
                        <img class="d-block mx-auto w-80 img-responsive image-to-zoom" src="<?php echo $image_path; ?>" alt="Scan <?php echo $i; ?>">
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
            <!-- Flèches suivant/précédent -->
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <img src="../media/fleche_gauche.png" alt="Previous" style="width: 50px;">
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <img src="../media/fleche_droite.png" alt="Next" style="width: 50px;">
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>


    <!-- Boîte modale pour l'affichage du scan -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <img class="img-fluid" id="modalImage" src="" alt="">
          </div>
        </div>
      </div>
    </div>

</div>


<script>
// Affichage du scan dans la boîte modale
$('.image-to-zoom').on('click', function() {
    var imagePath = $(this).attr('src');
    $('#modalImage').attr('src', imagePath);
    $('#imageModal').modal('show');
});

// Récupération des éléments pertinents
var btnTranscription = document.getElementById('btnTranscription');
var btnNormalisation = document.getElementById('btnNormalisation');
var texte = document.getElementById('texte');

// Ajout d'écouteurs d'événements pour les boutons
btnTranscription.addEventListener('click', function() {
    // Afficher la copie originale et masquer la régularisation
    var regs = document.querySelectorAll('reg');
    var origs = document.querySelectorAll('orig');
    var dels = document.querySelectorAll('del');
    
    // Parcourir toutes les balises reg et orig pour les afficher ou les masquer
    regs.forEach(function(reg) {
        reg.style.display = 'none';
    });
    origs.forEach(function(orig) {
        orig.style.display = 'inline';
    });
    dels.forEach(function(del) {
        del.style.display = 'inline';
    });

    // Suppression de la classe transcription qui remet les modifications en couleur
    texte.classList.remove('normalisation');

});

btnNormalisation.addEventListener('click', function() {
    // Masquer la copie originale et afficher la régularisation
    var regs = document.querySelectorAll('reg');
    var origs = document.querySelectorAll('orig');
    var dels = document.querySelectorAll('del');
    
    // Parcourir toutes les balises reg et orig pour les afficher ou les masquer
    regs.forEach(function(reg) {
        reg.style.display = 'inline';
    });
    origs.forEach(function(orig) {
        orig.style.display = 'none';
    });
    dels.forEach(function(del) {
        del.style.display = 'none';
    });

    // Ajout de la classe transcription qui met le texte en noir
    texte.classList.add('normalisation');   
});


// Affichage des scans
let slideIndex = 0;
const slides = document.querySelectorAll('.slide');

function nextSlide() {
  slides[slideIndex].classList.remove('active');
  slideIndex = (slideIndex + 1) % slides.length;
  slides[slideIndex].classList.add('active');
}

function prevSlide() {
  slides[slideIndex].classList.remove('active');
  slideIndex = (slideIndex - 1 + slides.length) % slides.length;
  slides[slideIndex].classList.add('active');
}


// Affichage du texte normalisé en noir
// Récupération de toutes les balises <add> dans le texte
var balisesAdd = document.querySelectorAll('add');

// Parcourir toutes les balises <add> et changer leur couleur en noir
balisesAdd.forEach(function(balise) {
    balise.style.color = 'black';
});

</script>

<style>
/* Afficher la copie originale */
reg {
    display: none;
}
/* Afficher la régularisation */
orig {
    display: inline;
}
del {
    text-decoration: line-through;
}
mod[resp="P"] {
  color: red; 
}
mod[resp="E"] {
  color: #AB9FFB;
}
#texte {
  white-space : normal; 
  line-height: 25px !important; 
}

</style>

</body>
</html>