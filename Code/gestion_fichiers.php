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

// Vérifier si le paramètre "alert" est présent dans l'URL
if(isset($_GET['alert'])) {
    // Récupérer la valeur du paramètre "alert"
    $alert = $_GET['alert'];
    
    // Vérifier la valeur du paramètre "alert" et afficher l'alerte appropriée
    if($alert === "success") {
        // Vérifier si l'ID supprimé est présent dans l'URL
        if(isset($_GET['id_supprime'])) {
            // Récupérer l'ID supprimé
            $id_supprime = $_GET['id_supprime'];
            echo "<script>alert('Le texte $id_supprime a été supprimé avec succès.');</script>";
        } else {
            echo "<script>alert('Le texte a été supprimée avec succès.');</script>";
        }
    } elseif($alert === "error") {
        echo "<script>alert('Une erreur est survenue lors de la suppression du texte. Veuillez réessayer.');</script>";
    }
}

?>


<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--- Feuilles de style --->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

    <!--- Scripts JS et JQuery --->
    <script src="scripts/jquery-3.7.1.min.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src="scripts/bootstrap.min.js"></script> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

    <title>Page de gestion des fichiers</title>
  </head>



<body>
<!--- Bandeau de navigation --->
<div class="container">
  <header class="d-flex justify-content-center py-3">
    <img id="logo" src="media/e-calm-logo.png" alt="logo">
    <ul class="nav nav-pills">
      <li class="nav-tabs"><a href="recherche.php" class="nav-link">Recherche</a></li>
      <li class="nav-tabs"><a href="gestion_fichiers.php" class="nav-link active nav-color">Tableau de bord</a></li>
      <li class="nav-tabs"><a href="https://e-calm.huma-num.fr" target="_blank" class="nav-link">Projet E-Calm</a></li>
    </ul>
      <?php include "bouton_deconnexion.php"; ?>  
  </header>
</div>

<!--- Tableau --->
<div class="table-responsive">
<table class="table table-hover">
  <caption>Cette page permet de visualiser l'ensemble des fichiers disponibles. Vous pouvez également en ajouter en cliquant sur le bouton "Ajouter des fichiers".</caption>
  <thead class="thead-light">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nom du fichier</th>
      <th scope="col">Date d'ajout</th>
      <th scope="col">Suppression</th>
    </tr>
  </thead>
  <tbody>

<?php
// Connexion à la base de données
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=CopXMLSCAN', 'baderl', '&baderl');
    } catch (PDOException $e) {
        // En cas d'erreur de connexion, affichez l'erreur
        die('Erreur de connexion à la base de données : ' . $e->getMessage());
    }
// Requête SQL pour récupérer les données
$query = $pdo->query("SELECT IDFICHIER, DATEAJOUT FROM FICHIER");

if ($query) {
// Variable pour compter le nombre de lignes
  $row_number = 1;

  // Afficher les données dans le tableau
  while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
      echo "<tr>";
      echo "<th scope='row'>".$row_number."</th>"; // Affichage du numéro de ligne
      echo "<td><a href='affichage_texte.php?id=".$row["IDFICHIER"]."'>{$row['IDFICHIER']}</a></td>";
       // Affichage du nom de fichier depuis la base de données
      echo "<td>".$row["DATEAJOUT"]."</td>"; // Affichage de la date d'ajout depuis la base de données
      echo "<td><a class='btn btn-danger btn-sm' role='button' role='button' href='supprimer.php?id=".$row['IDFICHIER']."'>Supprimer</a></td>";
      echo "</tr>";
      $row_number++; // Incrémentation du compteur de lignes
  }
} else {
  echo "Erreur lors de l'exécution de la requête SDL.";
}
?>
  </tbody>
  </table>
</div>

<div class="col-md-3 text-center">
      <div class="d-flex align-items-center justify-content-center" style="height: 100%;">
        <a type="submit" href="ajout_fichiers.php" class="btn btn-perso btn-lg">Ajouter des fichiers</a>
      </div>
    </div>

</body>
</html>
