<?php
include_once 'connexion_bdd.php'; 

// Initialiser la variable $sql 
$sql = "SELECT * FROM FICHIER WHERE 1=1"; // Ajouter 1=1 pour assurer le bon fonctionnement du WHERE

// Les filtres
if (isset($_POST['ok'])) {
    // Nom du fichier (IDFICHIER)
    if (!empty($_POST['fichier'])) {
        $fichier = $_POST['fichier'];
        $sql .= " AND IDFICHIER LIKE '%$fichier%'";
    }

    // Corpus (CORPUS)
    if (!empty($_POST['corpus'])) {
        $corpus = $_POST['corpus'];
        $sql .= " AND CORPUS IN ('" . implode("','", $corpus) . "')";
    }

    // Élève (ELEVE)
    if (!empty($_POST['eleve'])) {
        $eleve = $_POST['eleve'];
        $sql .= " AND ELEVE = '$eleve'";
    }

    // Classe (CLASSE)
    if (!empty($_POST['classe'])) {
        $classe = $_POST['classe'];
        $sql .= " AND CLASSE = '$classe'";
    }

    // Niveau (NIVEAU)
    if (!empty($_POST['niveau'])) {
        $niveau = $_POST['niveau'];
        $sql .= " AND NIVEAU IN ('" . implode("','", $niveau) . "')";
    }

    // Année (ANNEE)
    if (!empty($_POST['annee'])) {
        $annee = $_POST['annee'];
        $sql .= " AND ANNEE IN ('" . implode("','", $annee) . "')";
    }

    // Version (VERSION)
    if (!empty($_POST['version'])) {
        $version = $_POST['version']; 
        $sql .= " AND VERSION IN ('" . implode("','", $version) . "')"; 
    }

    // Temps d'écriture (TEMPSECRITURE)
    if (!empty($_POST['temps_ecriture'])) {
        $temps_ecriture = $_POST['temps_ecriture'];
        $sql .= " AND TEMPSECRITURE IN ('" . implode("','", $temps_ecriture) . "')";
    }

    // Normalisation (NORMALISATION)
    if (!empty($_POST['normalisation'])) {
        $normalisation = $_POST['normalisation']; 
        $sql .= " AND NORMALISATION = '$normalisation'";
    }

    // Commentaires (COMMENTAIRES)
    if (!empty($_POST['commentaires'])) {
        $commentaires = $_POST['commentaires'];
        $sql .= " AND COMMENTAIRES IN ('" . implode("','", $commentaires) . "')";
    }
}
else {
    echo "Pas de requête POST reçue";
}

$stmt = $pdo->query($sql);

//Tableau des resultats
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>