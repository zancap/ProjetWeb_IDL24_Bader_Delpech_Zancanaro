<?php
//$xmlContent = file_get_contents('CO-3-2014-ARG-D1-E3-V2.xml');

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
            //$valide = validateXmlWithDtd($xmlContent, $dtd);
            $valide = TRUE;

            if ($valide) {
                // Le fichier XML est valide par rapport à son DTD
                // Traitements
                // Créer un objet DOMDocument et charger le contenu XML
                $dom = new DOMDocument();
                $dom->loadXML($xmlContent);

                // // Récupérer la première et unique balise <text> = $texte
                // $textElement = $dom->getElementsByTagName("text")->item(0);
                
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
                        
                            $bodyContent .= $dom->saveXML($child);
                    }
                    
                    // Remplacer les balises <lb/> par <br/>
                    $bodyContent = str_replace('<lb/>', '<br/>', $bodyContent);

                }  
                else {
                    // Aucune balise <body> trouvée
                    echo "Aucune balise <body> n'a été trouvée dans le fichier XML.";
                }

                // Initialiser une variable pour stocker la nombre max actuel de temps d'écriture
                $maxNumberAfterT = 0;
                // Initialiser une variable pour savoir si on a trouvé une balise <mod> dont l'attribut resp a pour valeur chercheur
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
                        // else {
                        //     echo "Valeur de l'attribut seq non reconnu.";
                        // }
                        // Si resp="chercheur" cela signifie qu'il y a une normalisation
                        if ($respValue == "chercheur") {
                            $foundChercheur = TRUE;
                        }
                    }
                }
                else {
                    // Aucune balise <mod> trouvée
                    echo "Aucune balise <mod> n'a été trouvée dans le fichier XML.";
                }

                // Initialiser une variable pour stocker les intervenants sur le texte
                $intervenants = [];

                if ($noteElements !== null) {
                    // Parcourir tous les éléments <note>
                    foreach ($noteElements as $noteElement) {
                        // Si on trouve des balises <notes> cela veut dire qu'il y a des intervenants qui ont fait des commentaires donc on récupère l'attribut resp
                        $respValue = $noteElement->getAttribute('resp');
                        if (!in_array($respValue, $intervenants)) {
                            $intervenants[] = $respValue;
                        }
                        // Récupérer la valeur de l'attribut "seq" en comparant le nombre après le T puisque les notes peuvent ajoute un temps d'écriture en plus des temps d'écriture obtenus grâce aux balises <mod>
                        $seqValue = $noteElement->getAttribute('seq');
                        $seqValueAfterT = substr($seqValue, 1);
                        if ($seqValueAfterT >= $maxNumberAfterT) {
                            $maxNumberAfterT = $seqValueAfterT;
                        }            
                    }
                }
                else {
                    // Aucune balise <mod> trouvée
                    echo "Aucune balise <mod> n'a été trouvée dans le fichier XML.";
                }

                // Echappement des l'apostrophe pour le texte
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
                // echo $texte."<br>";
                // Chaine contenant les intervenant des commentaires
                $commentaire = implode(",", $intervenants);

                // Affichage des résultats du parsing
                echo "Il y a eu " . $temps_ecriture." temps d'écriture sur ce texte.<br>";
                if ($normalisation) {
                    echo "Ce texte a été normalisé.<br>";
                }
                else {
                    echo "Ce texte n'a pas été normalisé.<br>";
                }
                echo "Les intervenants de ce texte sont : $commentaire.<br>";
                
                // $nb_tokens =
                echo "Le fichier XML a bien été parsé.";
            }
            else {
                // Le fichier XML n'est pas valide par rapport à son DTD
                echo "Erreur : Le fichier XML n'est pas valide par rapport à son DTD.";
                exit;
            }

        }
        else {
            echo "Le fichier temporaire '$fileName' n'a pas pu être ouvert.";
        }
    }
    else {
        echo "Le fichier temporaire $tempFile n'existe pas.";
    }
}
else {
    echo "Aucun fichier transmis au script.";
}

//include 'validation_dtd.php';

?>