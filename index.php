<?php require './config/config.php';

$isLoggedIn = isset($_SESSION['user_id']);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livre d'or</title>
    <link rel="stylesheet" href="./assets/css/index.css">
</head>
<body>
    <header>
        <nav class="nav-bar">
            <a href="index.php" class="nav-link">
                <img src="./assets/images/logo.png" alt="logo" class="logo">
            </a>
            <ul>
                <?php if ($isLoggedIn): ?>
                    <!-- Éléments de navigation pour les utilisateurs connectés -->
                    <li><a href="index.php?page=livre-or">Voir les messages</a></li>
                    <li><a href="index.php?page=commentaires">Ajouter un message</a></li>
                    <li><a href="index.php?page=profil">Mon profil</a></li>
                    <li><a href="index.php?page=logout">Déconnexion</a></li>
                <?php else: ?>
                    <!-- Éléments de navigation pour les utilisateurs non connectés -->
                    <li><a href="index.php?page=livre-or">Voir les messages</a></li>
                    <li><a href="index.php?page=register">S'inscrire</a></li>
                    <li><a href="index.php?page=login">Se connecter</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>
        <section class="container">
            <?php
                function loadPage($page = null) {
                    require BASE_PATH . '/files/' . $page . '.php';
                    }
                    if (!defined('BASE_PATH')) {
                        define('BASE_PATH', __DIR__);
                    }
                
                    // Initialiser Navigation
                    $Navigation = new Navigation($page ?:'page', 'files', 'home');
                    
                    // Obtenir le chemin du fichier principal
                    $filename = $Navigation->getMainFilePath();
                    
                    // Vérifier si le fichier existe
                    if (file_exists($filename)) {
                        require $filename;
                    } else {
                        // Essayer de trouver le fichier dans les sous-dossiers
                        $alternatePaths = [
                            BASE_PATH . '/files/' . $Navigation->getPage() . '.php',
                
                        ];
                    
                    $fileFound = false;
                    foreach ($alternatePaths as $path) {
                        if (file_exists($path)) {
                            require $path;
                            $fileFound = true;
                            break;
                        }
                    }
                    
                    // Si aucun fichier n'est trouvé, charger la page par défaut
                    if (!$fileFound) {
                        require BASE_PATH . '/files/home.php';
                        // Optionnellement, enregistrer l'erreur dans un journal
                        error_log("Page non trouvée: " . $Navigation->getPage());
                    }
                }
            ?>
        </section>
    </main>
    <footer class="footer">
        <ul>
            <li>©Livre d'or</li>
            <li>Mentions légales</li>
            <li>Politique de confidentialité</li>
            <li>Contact</li>
        </ul>
    </footer>
</body> 
</html>
