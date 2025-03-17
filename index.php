<?php 
require_once './config/config.php';

$isLoggedIn = isset($_SESSION['user_id']);

// Déterminer la page à afficher
$fileName = isset($_GET['page']) ? $_GET['page'] : NULL;

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livre d'or</title>
    <link rel='stylesheet' href='./assets/css/index.css'>
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
                // Inclure la page à afficher
                if ($fileName && file_exists("./files/$fileName.php")){
                    include("./files/$fileName.php");
                } else {
                    include("./files/home.php");
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