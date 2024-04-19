<?php

if(isset($_GET['id'])) {
    // Récupérez la valeur de l'ID depuis la superglobale $_GET
    $id = $_GET['id'];

    include "../modeles/connexion_bdd.php";

    // Requête pour obtenir le nombre de scans liés à cet ID
    $requete = "SELECT * FROM FICHIER WHERE IDFICHIER = '$id'";
    $resultat = $pdo->query($requete);
    $row = $resultat->fetch(PDO::FETCH_ASSOC); // Récupération d'une ligne dans un tableau associatif où on peut utiliser les noms des colonnes 

    $nombre_scans = $row['NOMBRESCANS'];
    $niveau = $row['NIVEAU'];
    $eleve = $row['ELEVE'];
    $classe = $row['CLASSE'];
    $annee = $row['ANNEE'];
    $corpus = $row['CORPUS'];
    $texte= $row['TEXTE'];
}  

?>