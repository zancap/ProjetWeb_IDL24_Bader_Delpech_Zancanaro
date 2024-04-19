<?php

    /* connexion à la base  */
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=CopXMLSCAN', 'delpechb', '&delpechb;');
        //print "La base est ouverte !<br/>\n";
    }    
    catch(Exception $e) {
        die('Erreur : '.$e->getMessage());
        //print "La base n'est pas ouverte !<br/>\n";
}
   
?>