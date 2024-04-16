<?php

if ($commonFileName != null && isset($nb_fichiers_upload)) {
    $filename = $commonFileName; # Récupération du nom commun calculé dans "traitement.php"
    $nb_scans = $nb_fichiers_upload-1; # On récupère le nombre de fichiers uploadés - 1 (.xml) pour compter le nombre de scans

    // Séparation du nom de fichier en parties en utilisant le tiret comme délimiteur
    $parts = explode("-", $filename);

    // Extraction des différentes parties
    $classe = $parts[3]; // "ARG"
    $niveau = $parts[1]; // 3
    $eleve = $parts[5]; // "E3"
    $annee = (int)$parts[2]; // 2014
    $version = (int)substr($parts[6], 1); // 2

    // Extraction du corpus en fonction du l'id de l'élève
    if (substr($eleve, 0, 1) == 'E') {
        $corpus = 'EcriScol';
    } 
    elseif (substr($eleve, 0, 1) == 'S') {
        $corpus = 'ScolEdit';
    }

    // Affichage des résultats pour vérification
    //echo "'Classe: $classe<br>Niveau: $niveau<br>Élève: $eleve<br>Année: $annee<br>Corpus: $corpus<br>Version: $version<br>Nombre de scans: $nb_scans<br>')";

    echo "Le nom du fichier : '".$filename."'a été parsé avec succès.";
}
else {
    echo "Erreur de récupération du nom commun de fichiers.";
    exit;
}

?>
