<?php
// Vérifiez si l'ID du fichier à supprimer a été envoyé via la méthode GET
if(isset($_GET['id'])) {
    // Récupérez la valeur de l'ID depuis $_GET
    $id = $_GET['id'];
    echo $id;

    include "../modeles/connexion_bdd.php"; // Script de connexion à la BDD

    // Requête pour obtenir le nombre de scans liés à cet ID
    $requete_nombre_scans = "SELECT NOMBRESCANS FROM FICHIER WHERE IDFICHIER = '$id'";
    $resultat = $pdo->query($requete_nombre_scans);
    $row = $resultat->fetch(PDO::FETCH_ASSOC); // Récupération d'une ligne dans un tableau associatif où on peut utiliser les noms des colonnes 
    $nombre_scans = $row['NOMBRESCANS'];

    // Requête de suppression du fichier dont l'ID est passé en GET
    $requete = "DELETE FROM FICHIER WHERE IDFICHIER = '$id'";


    // Exécuter la requête de suppression
    if ($pdo->query($requete) == TRUE) {
        // Cas où le nombre de scan est bien supérieur à 0 et donc où on peut effectuer les opérations de suppression
        if ($nombre_scans > 0) {
            // Supprimer le fichier XML
            $chemin_xml = "../uploads/$id.xml";
            if (file_exists($chemin_xml)) {
                unlink($chemin_xml);
            }
            
            // Supprimer les fichiers images
            for ($i = 1; $i <= $nombre_scans; $i++) { // Boucle pour créer les noms des fichiers images en fonction du nombre de scans
                $chemin_image = "../uploads/{$id}-" . sprintf("%03d", $i) . ".jpg"; // %03d = formatage de $i à la forme "OOi" donc 001, 002, etc.
                if (file_exists($chemin_image)) {
                    unlink($chemin_image);
                }
            }
            header("Location: ../vues/gestion_fichiers.php?alert=success&id_supprime=$id"); // Rediriger vers la page de gestion des fichiers
            exit();
        }
        // Cas où le nombre de scan est incorrect
        else {
            header("Location: ../vues/gestion_fichiers.php?alert=error"); // Rediriger vers la page de gestion des fichiers avec une erreur
            exit();
        }
    }
}    
// Si on n'a pas reçu de $_GET['id']
else {
    header("Location: ../vues/gestion_fichiers.php?alert=error"); // Rediriger vers la page de gestion des fichiers avec une erreur
    exit();
}

?>