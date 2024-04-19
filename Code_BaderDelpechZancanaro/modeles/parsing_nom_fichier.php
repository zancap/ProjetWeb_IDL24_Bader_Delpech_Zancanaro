<?php

if ($commonFileName != null && isset($nb_fichiers_upload)) { // Vérification que le nom de fichier commun est défini et qu'il y a des fichiers uploadés
    $filename = $commonFileName; // Récupération du nom commun calculé dans "traitement.php"
    $nb_scans = $nb_fichiers_upload-1; // On récupère le nombre de fichiers uploadés - 1 (.xml) pour compter le nombre de scans

    // Séparation du nom de fichier en parties en utilisant le tiret comme délimiteur
    $parts = explode("-", $filename);

    // Extraction des différentes parties
    $niveau = $parts[1];
    $annee = (int)$parts[2]; 
    $classe = $parts[3]; 
    $eleve = $parts[5]; 
    $version = (int)substr($parts[6], 1); // On ne prend que le chiffre après V ex : "V1"

    // Extraction du corpus en fonction du l'id de l'élève
    if (substr($eleve, 0, 1) == 'E') {
        $corpus = 'EcriScol';
    } 
    elseif (substr($eleve, 0, 1) == 'S') {
        $corpus = 'ScolEdit';
    }

    echo "<p>Le nom du fichier : '".$filename."'a été parsé avec succès.</p>"; // Confirmation du parsing
}
else {
    echo "<p>Erreur de récupération du nom commun de fichiers.</p>"; // Message d'erreur si le parsing n'a pas pu être fait
    exit; // Sortie du script
}

?>
