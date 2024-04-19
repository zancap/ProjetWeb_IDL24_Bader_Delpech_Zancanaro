<?php
session_start();

// Vérification si l'utilisateur clique sur "Tableau de bord"
if (isset($_GET['tableau_de_bord'])) {
    // Vérification si l'utilisateur n'est pas connecté
    if (!isset($_SESSION['utilisateur_connecte']) || $_SESSION['utilisateur_connecte'] !== true) {
        // Redirection vers la page de connexion
        header("Location: ../controleur/index.php");
        exit(); 
    } else {
        // Redirection vers la page de gestion des fichiers
        header("Location: ../vues/gestion_fichiers.php");
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

    <title>Page de résultats</title>
  </head>

<body>
<!--- Bandeau de navigation --->
<div class="container">
  <header class="d-flex justify-content-center py-3">
    <img id="logo" src="../media/e-calm-logo.png" alt="logo">
    <ul class="nav nav-pills">
      <li class="nav-tabs"><a href="../vues/recherche.php" class="nav-link">Recherche</a></li>
      <li class="nav-tabs"><a href="../vues/tableau_resultats.php" class="nav-link active nav-color">Résultats</a></li>
      <li class="nav-tabs"><a href="../vues/tableau_resultats.php?tableau_de_bord=true" class="nav-link">Tableau de bord</a></li>
      <li class="nav-tabs"><a href="https://e-calm.huma-num.fr" target="_blank" class="nav-link">Projet E-Calm</a></li>
    </ul>
  </div>
    <?php include "../modeles/bouton_deconnexion.php"; ?>  
  </header>
</div>

<!--- Tableau --->
<div class="table-responsive table-container">
<table class="table caption-top table-hover text-center">
  <caption>Voici les résultats de votre recherche. Cliquez sur le nom d'un fichier pour y accéder.</caption>
  <thead class="thead-light">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nom du fichier</th>
      <th scope="col">Corpus</th>
      <th scope="col">Année</th>
      <th scope="col">Élève</th>
      <th scope="col">Classe</th>
      <th scope="col">Niveau</th>
      <th scope="col" data-toggle="tooltip" title="Pour la même consigne, l'élève a pu réaliser plusieurs copies.">Version</th>
      <th scope="col" data-toggle="tooltip" title="Correspond au nombre de passages sur une copie. Par exemple, au T1 l'élève rédige, au T2 l'enseignant ajoute un commentaire, au T3 l'élève continue sa rédaction, etc.">Temps</th>
      <th scope="col" data-toggle="tooltip" title='Une normalisation linguistique a été ajoutée à certains textes. Si vous choisissez "Oui", vous pourrez visualiser la transcription du texte initial et sa version normalisée.'>Normalisation</th>
      <th scope="col" data-toggle="tooltip" title="Ajouts effectués par l'élève (E) ou commentaires du professeur (P).">Commentaires</th>
      <!-- <th scope="col" data-toggle="tooltip" title="Concerne la longueur du texte. Court = moins de 50 mots. Moyen = entre 50 et 150 mots. Long = plus de 150 mots.">Longueur</th> -->
      <th scope="col">Nb de scans</th>
      <th scope="col">Date d'ajout</th>
      <!-- <th scope="col" data-toggle="tooltip" title="Si la normalisation a été effectuée, un taux d'erreur entre l'écrit de l'élève et la version normalisée est calculé.">Taux d'erreur</th>  -->
    </tr>
  </thead>
  <tbody>

<?php
   // Affichage des résultats
  include '../modeles/query.php';
  $rowCount = 0;
  foreach ($result as $row) {
    $rowCount++;
    echo "<tr>";
    echo "<th scope='row'>$rowCount</th>";
    echo "<td><a target='_blank' href='../vues/affichage_texte.php?id=".$row['IDFICHIER']."'>{$row['IDFICHIER']}</a></td>";
    echo "<td>{$row['CORPUS']}</td>";
    echo "<td>{$row['ANNEE']}</td>";
    echo "<td>{$row['ELEVE']}</td>";
    echo "<td>{$row['CLASSE']}</td>";
    echo "<td>{$row['NIVEAU']}</td>";
    echo "<td>{$row['VERSION']}</td>";
    echo "<td>{$row['TEMPSECRITURE']}</td>";
    echo "<td>{$row['NORMALISATION']}</td>";
    echo "<td>{$row['COMMENTAIRES']}</td>";
    // echo "<td>{$row['LONGUEURTEXTE']}</td>";
    echo "<td>{$row['NOMBRESCANS']}</td>";
    echo "<td>{$row['DATEAJOUT']}</td>";
    echo "</tr>";
  }
  ?>

  </tbody>
</table>
</div>


<script>
// Affichage des tooltips
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>


</body>
</html>

