<?php
if (isset($_SESSION['utilisateur_connecte'])) { ?>
    <div class="btn-connexion">
        <a class="btn btn-danger mt-2 btn-sm" href="<?php echo $_SERVER['PHP_SELF']; ?>?deconnexion=true" role="button">Déconnexion</a>
    </div>
<?php }
else { ?>
    <div class="btn-connexion">
        <a class="btn btn-perso mt-2 btn-sm" href="../controleur/index.php" role="button">Connexion</a>
    </div>
<?php }

// Déconnexion de l'utilisateur
if (isset($_GET['deconnexion'])) {
    // Détruire la session
    session_destroy();
    // Rediriger vers la page d'accueil
    header("Location: ../controleur/index.php");
    exit();
}
?>