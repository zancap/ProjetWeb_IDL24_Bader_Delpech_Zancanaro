<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--- Feuilles de style --->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">

    <!--- Scripts JS et JQuery --->
    <script src="scripts/jquery-3.7.1.min.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

    <title>Page d'accueil</title>
  </head>

  <body>
    <main>
    <div class="container">
      <div class="titre">E-CALM</div>
      <form action="#" method="POST">

      <div class="row justify-content-center">
        <div class="col-sm-6">
          <strong><label for="identifiant">Identifiant</label></strong>
          <input type="text" class="form-control" id="identifiant" name="identifiant">
        </div>   
      </div>

      <div class="row justify-content-center">
        <div class="col-sm-6">
          <strong><label for="mdp">Mot de passe</label></strong>
          <input type="password" class="form-control" id="mdp" name="mdp">
        </div>
      </div>
      <br>
      <div class="row-cols-auto">
          <button type="submit" class="btn btn-perso btn-lg">Connexion</button>
          <a href="recherche.php">Continuer sans connexion</a>
      </div>
      </div>
      </form>
      <br>
      <div class="info-projet">
      <p>Pour en savoir plus sur le projet, cliquez <a href="https://e-calm.huma-num.fr" target="_blank">ici</a>.</p>
      </div>
    </div>
  </main>

  <!-- Boîte modale en cas d'identifiant/mdp incorrects -->
  <div class="modal fade" id="erreurModal" tabindex="-1" role="dialog" aria-labelledby="erreurModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-center" id="erreurModalLabel">Erreur de connexion</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">x</span>
          </button>
        </div>
        <div class="modal-body">
          Vos identifiants de connexion sont incorrects. Veuillez réessayer. <br>Si vous choisissez de ne pas vous connecter, vous ne pourrez pas ajouter ou supprimer de fichier.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-perso" data-dismiss="modal">Fermer</button>
        </div>
      </div>
    </div>
  </div>

  </body>
</html>

<?php

session_start(); // Démarre une nouvelle session ou reprend une session existante

// Vérification si l'utilisateur est déjà connecté
if(isset($_SESSION['utilisateur_connecte']) && $_SESSION['utilisateur_connecte'] === true) {
    // Rediriger l'utilisateur vers une autre page s'il est déjà connecté
    header("Location: recherche.php");
    exit(); 
}


// Vérification si les données de connexion ont été soumises
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connexion à la base de données
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=CopXMLSCAN', 'baderl', '&baderl');
    } catch (PDOException $e) {
        // En cas d'erreur de connexion, affichez l'erreur
        die('Erreur de connexion à la base de données : ' . $e->getMessage());
    }

    // Requête SQL pour sélectionner l'utilisateur correspondant aux identifiants fournis
    $sql = "SELECT * FROM UTILISATEUR WHERE LOGIN = :login AND MDP = :mdp";

    // Préparation de la requête
    $stmt = $pdo->prepare($sql);

    // Exécution de la requête avec les identifiants fournis
    $stmt->bindParam(':login', $_POST['identifiant']);
    $stmt->bindParam(':mdp', $_POST['mdp']);
    $stmt->execute();

    // Récupération de l'utilisateur
    $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérification si l'utilisateur existe
    if ($utilisateur) {
        $_SESSION['utilisateur_connecte'] = true;
        header("Location: gestion_fichiers.php");
        exit(); 
    } else {
      // Affichage de la boîte modale en cas d'échec de connexion
      echo "<script>$('#erreurModal').modal('show');</script>";
    }
}

?>