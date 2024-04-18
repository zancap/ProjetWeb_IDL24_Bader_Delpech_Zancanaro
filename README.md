# Home page – Page de connexion (*index.php*) :

Les champs *“Identifiant”* et *“Mot de Passe”* doivent être remplis par l’utilisateur pour avoir accès à la page de gestion des fichiers dans la base de données.

Au clic sur *“Connexion”*, et si le mot de passe et l’identifiant ont été correctement saisis, l’utilisateur va être redirigé à la page de gestion des fichiers.

Au clic sur *“Continuer sans connexion”* l’utilisateur va être redirigé sur la page de recherche qui permet d’explorer le contenu de la base des données grâce à des filtres pré-remplis et à des champs de recherche libres.

Au clic sur *“Ici”* en bas de la home page (*“Pour en savoir plus sur le projet, cliquez ici.”*) l’utilisateur sera redirigé sur le site principal du projet *E-Calm* ( https://e-calm.huma-num.fr/ ).

Il est toujours possible de revenir à cette page à partir de toutes les autres grâce au bouton Connexion/Déconnexion en haut à droite de la page.

# Ajout de fichiers – Accessible seulement après connexion pour les utilisateurs enregistrés (*ajout_fichiers.php*) :

L’utilisateur connecté peut ici ajouter des fichiers : à chaque fichier xml ajouté, un ou plusieurs scans (fichiers d’images jpg) doivent être associés. Le fichier xml et ses scans doivent impérativement avoir le même nom (extension exclue) pour être correctement ajoutés à la base des données et uploadés sur le serveur.

Un message d’erreur est envoyé si l’utilisateur essaye d’ajouter un fichier xml sans ses scans ou si des scans ne correspondent pas à un fichier xml.

Un message d’erreur apparaît si un fichier est déjà existant dans la base de données.

Grâce à cette page les informations contenues dans le fichier xml sont parsées et déposées dans la base des données pour être ensuite consultées par les chercheurs et les autres utilisateurs du site web.

# Tableau de bord/Gestion de fichiers – Accessible seulement après connexion pour les utilisateurs enregistrés (*gestion_fichiers.php*) :

Cette page regroupe tous les fichiers présents dans la base de données.

Le bouton *“Supprimer”* permet de supprimer le fichier à la fois de la base des données et de la liste des fichiers uploadés sur le serveur.

Les noms des fichiers sont des liens vers la page d’affichage.

# Les filtres – Page de recherche accessible à tous utilisateurs sans connexion (*recherche.php*) :

L'utilisateur peut choisir autant de filtres qu’il/elle souhaite. Tous les filtres peuvent être combinés, et si l’utilisateur n’en choisit aucun, tous les fichiers sont affichés.

Les champs *“Nom du fichier”*, *“Elève”* et *“Classe”* peuvent être librement complétés par l’utilisateur. Les menus déroulants, ainsi que les filtres avec des checkbox à cocher, permettent la sélection de plusieurs valeurs. Pour *“Normalisation”* et *“Taux d’erreur”*, une seule valeur peut être sélectionnée.

Cette page interroge la base de données pour comparer les filtres sélectionnés par l’utilisateur avec les valeurs contenues dans la base des données.

Une fois la recherche lancée, la page de résultats s’affiche.

# Page des résultats – Affiche la liste des fichiers correspondantes aux filtres sélectionnés (*resultats.php*) :

Le tableau correspond aux informations de la base de données, et les textes affichés correspondent à la recherche effectuée sur la page précédente. 

Le nom du fichier est cliquable et ouvre la page d’affichage du texte sélectionné.

# Page de contenu - Pour chaque fichier (*affichage_texte.php*) :

Cette page affiche le ou les scan(s) de la copie, la transcription du texte et la normalisation.

La transcription permet de visualiser, suivant des codes couleurs, les modifications apportées au texte par l'élève ou l’enseignant. Les différentes versions du texte sont aussi disponibles, et l'utilisateur peut ici choisir de visualiser seulement la transcription avec les modifications ou la version normalisée du texte.

# Toutes les pages :

Le bouton connexion/déconnexion en haut à droite de chaque page permet de revenir à la page d’accueil. Si l’utilisateur était connecté, la session est fermée.

# Pistes d’amélioration :

Dans la page d’ajout de fichiers, il serait intéressant de pouvoir ajouter un ensemble de fichiers xml et jpg même s’ils ne sont pas liés, et que l’association entre les fichiers soit faite automatiquement.

Le filtre *“longueur  du texte”* reste à développer. Lors du parsing, nous n’avons pas récupéré le nombre de tokens car la notion de mot est compliquée à définir dans une copie d’élève. De plus, le fichier xml contient de nombreuses balises qui peuvent rendre cette extraction complexe. Le filtre a donc été ajouté mais n’est pas utilisable, nous laissons cette fonctionnalité à développer pour une prochaine étape du projet.

Nous avions initialement prévu d’évaluer le *“Taux d’erreur”* pour chaque texte : mais comme le choix de ce qui constitue une erreur est subjective à l’enseignant, à la consigne, à l'âge de l'étudiant, etc. nous avons décidé de ne pas procéder au développement de ce filtre. 

La vérification de la conformité au DTD n’est pas fonctionnelle (mais script existant) car nous n’avons pas pu la tester avec un DTD conforme.

Nous avons essayé de respecter l’architecture MVC mais notre code n’est pas parfaitement modulable et il reste des parties de script dans les vues. Cet aspect est donc perfectible.

L'affichage des textes pourrait être amélioré dans des versions futures, en tenant compte des différents temps d'écriture, en ajoutant les notes et commentaires aux endroits adéquats de l'affichage, etc.

Il serait possible d'ajouter une fonctionnalité pour le téléchargement des fichiers en local, accessible seulement aux utilisateurs connectés.

