<?php

include '../modeles/connexion_bdd.php';

    // Requête SQL
    $requete = "INSERT INTO `FICHIER`(`IDFICHIER`, `CORPUS`, `ANNEE`, `ELEVE`, `CLASSE`, `NIVEAU`, `VERSION`, `TEMPSECRITURE`, `NORMALISATION`, `COMMENTAIRES`, `LONGUEURTEXTE`, `NOMBRESCANS`, `DATEAJOUT`, `TEXTE`) VALUES ('$filename', '$corpus', '$annee', '$eleve', '$classe', '$niveau', '$version', '$temps_ecriture', '$normalisation', '$commentaire', 'XXX', '$nb_scans', NOW(), '$texte')";

    //Exécution de la requête
    $reponse = $pdo->query($requete);

?>