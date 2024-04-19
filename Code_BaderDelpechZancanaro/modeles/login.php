<?php

session_start(); // Démarre une nouvelle session ou reprend une session existante

// Vérification si l'utilisateur est déjà connecté
if(isset($_SESSION['utilisateur_connecte']) && $_SESSION['utilisateur_connecte'] === true) {
    // Rediriger l'utilisateur vers une autre page s'il est déjà connecté
    header("Location: ../vues/recherche.php");
    exit(); 
}


// Vérification si les données de connexion ont été soumises
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connexion à la base de données
    include "../modeles/connexion_bdd.php";

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
        header("Location: ../vues/gestion_fichiers.php");
        exit(); 
    } else {
      // Affichage de la boîte modale en cas d'échec de connexion
      echo "<script>$('#erreurModal').modal('show');</script>";
    }
}

?>