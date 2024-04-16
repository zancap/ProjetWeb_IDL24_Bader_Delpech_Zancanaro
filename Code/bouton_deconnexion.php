<?php
if (isset($_SESSION['utilisateur_connecte'])) { ?>
    <div class="btn-connexion">
        <a class="btn btn-danger mt-2 btn-sm" href="<?php echo $_SERVER['PHP_SELF']; ?>?deconnexion=true" role="button">Déconnexion</a>
    </div>
<?php }
else { ?>
    <div class="btn-connexion">
        <a class="btn btn-perso mt-2 btn-sm" href="index.php" role="button">Connexion</a>
    </div>
<?php }
?>