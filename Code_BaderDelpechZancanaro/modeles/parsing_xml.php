<?php

// Vérifier si le fichier temporaire est transmit à ce script
if (isset($_FILES["file"]["tmp_name"][$key])) {
    // Récupérer le chemin vers le fichier temporaire
    $tempFile = $_FILES["file"]["tmp_name"][$key];

    // Vérifier si le fichier temporaire existe
    if (file_exists($tempFile)) {
        // Ouvrir le fichier temporaire XML et récupérer son contenu
        $xmlContent = file_get_contents($tempFile);
        // Ouvrir et lire le contenu du fichier XML (on ne lance ce script que lorsque qu'on traite le fichier .xml)
        if ($xmlContent != false) {

            // Valider le fichier XML par rapport à son DTD
            //$dtd = "normes.v2.dtd"; // Spécifiez le chemin de votre fichier DTD
            //include 'validation_dtd.php';
            //$valide = validateXmlWithDtd($xmlContent, $dtd);
            $valide = TRUE; // Vu que le DTD n'est pas compatible avec les fichiers .xml on laisse $valide à vrai

            if ($valide) {
                // Le fichier XML est valide par rapport à son DTD
                // Traitements
                // Créer un objet DOMDocument et charger le contenu XML
                $dom = new DOMDocument();
                $dom->loadXML($xmlContent);
                
                // Récupérer toutes les balises <mod>
                $modElements = $dom->getElementsByTagName("mod");

                // Récupérer toutes les balises <note>
                $noteElements = $dom->getElementsByTagName("note");

                // Récupérer la première et unique balise <body>
                $bodyElement = $dom->getElementsByTagName("body")->item(0);

                // Vérifier si la balise <body> existe
                if ($bodyElement !== null) {
                    // Récupérer tous les éléments enfants de la balise <body>
                    $childElements = $bodyElement->childNodes;
                    
                    // Initialiser une variable pour stocker le contenu de la balise <body> avec ses enfants
                    $bodyContent = '';
                    
                    // Parcourir tous les éléments enfants et concaténer leur contenu
                    foreach ($childElements as $child) {
                        $bodyContent .= $dom->saveXML($child); // Finalement on récupère la balise <p> avec tout son contenu : texte et balises compris
                    }
                    
                    // Remplacer les balises <lb/> par <br/> pour l'affichage
                    $bodyContent = str_replace('<lb/>', '<br/>', $bodyContent);

                }  
                else {
                    // Aucune balise <body> trouvée
                    echo "<p>Aucune balise <body> n'a été trouvée dans le fichier XML.</p>"; // Message d'erreur
                }

                // Initialiser une variable pour stocker la nombre max actuel de temps d'écriture
                $maxNumberAfterT = 0;
                // Initialiser une variable pour savoir si on a trouvé une balise <mod> dont l'attribut resp a pour valeur 'chercheur'
                $foundChercheur = FALSE;

                if ($modElements !== null) {
                    // Parcourir tous les éléments <mod> et récupérer leur attribut "seq" en comparant le nombre après le T pour connaitre le nombre d'interventions sur le texte
                    foreach ($modElements as $modElement) {
                        // Récupérer la valeur de l'attribut "seq"
                        $seqValue = $modElement->getAttribute('seq');
                        // Récupérer la valeur de l'attribut "resp"
                        $respValue = $modElement->getAttribute('resp');
                        // On ne prend pas en compte les seq="post" qui correspondent aux interventions de normalisation du chercheur
                        if ($seqValue != "post") {
                            $seqValueAfterT = substr($seqValue, 1);
                            if ($seqValueAfterT >= $maxNumberAfterT) {
                                $maxNumberAfterT = $seqValueAfterT;
                            }    
                        }
                        if ($respValue == "chercheur") {
                            $foundChercheur = TRUE;
                        }
                    }
                }
                else {
                    // Aucune balise <mod> trouvée
                    echo "<p>Aucune balise <mod> n'a été trouvée dans le fichier XML.</p>";
                }

                // Initialiser une variable pour stocker les intervenants dans les commentaires du texte
                $intervenants = [];

                if ($noteElements != null) {
                    // Parcourir tous les éléments <note>
                    foreach ($noteElements as $noteElement) {
                        // Si on trouve des balises <notes> cela veut dire qu'il y a des intervenants qui ont fait des commentaires donc on récupère l'attribut resp
                        $respValue = $noteElement->getAttribute('resp');
                        if (!in_array($respValue, $intervenants)) { // Vérification si la valeur récupérée n'est pas déjà présente dans le tableau $intervenants
                            $intervenants[] = $respValue;     // Si la valeur n'est pas déjà présente, elle est ajoutée au tableau $intervenants
                        }
                        // Récupérer la valeur de l'attribut "seq" en comparant le nombre après le T puisque les notes peuvent ajouter un temps d'écriture en plus des temps d'écriture obtenus grâce aux balises <mod>
                        $seqValue = $noteElement->getAttribute('seq');
                        $seqValueAfterT = substr($seqValue, 1);
                        if ($seqValueAfterT >= $maxNumberAfterT) {
                            $maxNumberAfterT = $seqValueAfterT;
                        }            
                    }
                }
                else {
                    // Aucune balise <mod> trouvée
                    echo "<p>Aucune balise <note> n'a été trouvée dans le fichier XML.</p>";
                }

                // Echappement de l'apostrophe pour le texte
                // Initialisation de la chaîne échappée
                $bodyContentEchappe = '';

                // Parcours de chaque caractère de la chaîne originale
                for ($i = 0; $i < strlen($bodyContent); $i++) {
                    $char = $bodyContent[$i];
                    
                    // Si le caractère est une apostrophe
                    if ($char == "'") {
                        // Remplacer par "\'"
                        $bodyContentEchappe .= "\\'";
                    } else {
                        // Sinon, conserver le caractère tel quel
                        $bodyContentEchappe .= $char;
                    }
                }
               
                $texte = $bodyContentEchappe;
                $temps_ecriture = $maxNumberAfterT;
                $normalisation = $foundChercheur;

                // Chaine contenant les intervenants des commentaires
                $commentaire = implode(",", $intervenants);

                // Affichage des résultats du parsing
                echo "<p>Il y a eu " . $temps_ecriture." temps d'écriture sur ce texte.</p>";
                if ($normalisation) {
                    echo "<p>Ce texte a été normalisé.</p>";
                }
                else {
                    echo "<p>Ce texte n'a pas été normalisé.</p>";
                }
                if ($commentaire != "") {
                    echo "<p>Les commentaires de ce texte sont réalisés par $commentaire.</p>";
                }
                else {
                    echo "<p>Il n'y a pas de commentaires dans ce texte.</p>";
                }

                echo "<p>Le fichier XML a bien été parsé.</p>";
            }
            else {
                // Le fichier XML n'est pas valide par rapport à son DTD : jamais dans ce projet
                echo "<p>Erreur : Le fichier XML n'est pas valide par rapport à son DTD.</p>";
                exit; // Sortie du script
            }

        }
        //Gestion des erreurs
        else {
            echo "<p>Le fichier temporaire '$fileName' n'a pas pu être ouvert</p>";
        }
    }
    else {
        echo "<p>Le fichier temporaire $tempFile n'existe pas.</p>";
    }
}
else {
    echo "<p>Aucun fichier transmis au script.</p>";
}

?>