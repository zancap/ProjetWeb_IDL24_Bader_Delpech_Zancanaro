<?php 
// Fonction pour valider le fichier XML par rapport à son DTD
function validateXmlWithDtd($xmlContent, $dtdFile) {
    libxml_use_internal_errors(true);
    $doc = new DOMDocument();
    $doc->loadXML($xmlContent);
    $isValid = $doc->validate();
    libxml_clear_errors();
    return $isValid;
}
?>

