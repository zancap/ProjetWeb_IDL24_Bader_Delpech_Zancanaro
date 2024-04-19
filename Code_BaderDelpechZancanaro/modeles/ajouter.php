<?php

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si des fichiers ont été correctement téléchargés
    if ($_FILES["file"]["name"][0]!="") {
        // Chemin de destination où les fichiers seront stockés
        $uploadDir = "../uploads/";

        // Initialiser une variable pour stocker le nom de fichier commun
        $commonFileName = null;

        $allowedExtensions = array("xml", "jpg"); // Extensions autorisées

        $nb_fichiers_upload = count($_FILES["file"]["name"]); // Compte le nombre de fichiers uploadés

        if ($nb_fichiers_upload >=2) {

            // Parcourir les fichiers téléchargés pour extraire le nom commun (avant l'extension)
            foreach ($_FILES["file"]["name"] as $key => $name) {

                $fileExtension = pathinfo($name, PATHINFO_EXTENSION); // Récupération de l'extension du fichier

                // Vérification que l'extension est autorisée
                if (!in_array($fileExtension, $allowedExtensions)) {
                    echo "<p>Erreur : Extension de fichier non autorisée.</p>";
                    exit; // Sortir du script si les extensions sont incorrectes
                }

                // Obtenir le nom du fichier sans l'extension et en ignorant le numéro du scan si c'est un .jpg
                $fileNameWithoutExtension = pathinfo($name, PATHINFO_FILENAME);
                if ($fileExtension == "jpg") {
                    $parts = explode("-", $fileNameWithoutExtension); // On coupe le nom du fichier aux '-'
                    $fileNameWithoutExtension = implode("-", array_slice($parts, 0, -1)); // On rassemble le nom du fichier sans la dernière partie qui correspond au numéro du scan '-001'
                }

                // Si c'est le premier fichier, le nom commun est initialisé avec le nom du premier fichier
                if ($key == 0) {
                    $commonFileName = $fileNameWithoutExtension;
                } else {
                    // Vérifier si le nom du fichier sans l'extension est différent du nom commun
                    if ($fileNameWithoutExtension != $commonFileName) {
                        echo "<p>Erreur : Les fichiers doivent porter le même nom (à l'exception de l'extension et du numéro de scan).</p>";
                        exit; // Sortir du script si les noms ne sont pas tous les mêmes
                    }
                }
            }

            include '../modeles/parsing_nom_fichier.php'; // Script que fait le parsing du nom du fichier .xml
            

            // Parcourir les fichiers téléchargés
            foreach ($_FILES["file"]["error"] as $key => $error) {
                if ($error == UPLOAD_ERR_OK) {
                    // Obtenir le nom du fichier
                    $fileName = basename($_FILES["file"]["name"][$key]);
                    // Construire le chemin complet du fichier
                    $uploadFile = $uploadDir . $fileName;

                    // Vérifier si le fichier est un fichier XML
                    if (pathinfo($uploadFile, PATHINFO_EXTENSION) == "xml") {
                        include '../modeles/parsing_xml.php'; // Script qui fait le parsing du fichier .xml
                        // Ajouter toutes les infos à la BDD
                        include "../modeles/insert_BDD.php";
                        // Si la requête fonctionne ==> faire les uploads
                        if ($reponse) {
                            // Déplacer le fichier téléchargé vers le répertoire d'uploads
                            if (move_uploaded_file($_FILES["file"]["tmp_name"][$key], $uploadFile)) {
                                echo "<p>Le fichier $fileName a été téléchargé avec succès.</p>";
                            } else {
                                echo "<p>Une erreur s'est produite lors de l'envoi du fichier $fileName.</p>";
                                exit();
                            }
                        }
                        else { 
                            echo "<p>Une erreur s'est produite lors de l'insertion des informations dans la BDD :".$pdo->errorInfo()[2]."</p>"; 
                            exit();
                        }
                    }
                    else {
                        // Déplacer le fichier téléchargé vers le répertoire d'uploads
                        if (move_uploaded_file($_FILES["file"]["tmp_name"][$key], $uploadFile)) {
                            echo "<p>Le fichier $fileName a été téléchargé avec succès.</p>";
                        } else {
                            echo "<p>Une erreur s'est produite lors de l'envoi du fichier $fileName.</p>";
                            exit();
                        }
                    }
                // Gestion des erreurs
                } else {
                    echo "<p>Erreur : Aucun fichier n'a été téléchargé ou une erreur s'est produite avec le fichier $key.</p>";
                }
            }
        }
        else {
            echo "<p>Erreur : Il faut obligatoirement uploader 2 fichiers minimum (.xml et .jpg).</p>";
        }
    } else {
        echo "<p>Erreur : Aucun fichier n'a été téléchargé.</p>";
    }
}
else {
        echo "<p>Erreur : Aucune requête post n'a été envoyée.</p>";
    }
?>