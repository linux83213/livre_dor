<?php
/*
if (isset($_GET['page']) && $_GET['page'] == 'inscription') {
    include 'files/inscription.php';
} elseif (isset($_GET['page']) && $_GET['page'] == 'connexion') {
    include 'files/connexion.php';
}
    */
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
            <img src="./assets/image/logo.png" alt="Logo du Livre d'or">
            <ul>
                <li><a href="index.php"></a></li>
                <li><a href="livre_dor.php">Voir les messages</a></li>
                <li><a href="./commentaires.php">Ajouter un message</a></li>
                <li><a href="./files/register.php?page=register.php">S'inscrire</a></li>
                <li><a href="login.php?page=./files/login.php">Se connecter</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="container">
            <h1>Bienvenue sur notre Livre d'or</h1>
            <h2>Partagez vos impressions</h2>
            <p>Bienvenue sur notre livre d'or, un espace où vous pouvez laisser vos messages et lire les témoignages des autres visiteurs.</p>
            <a href="ajouter_message.php" class="btn">Laisser un message</a>
        </section>
    </main>
    <footer>
        <p class="copyright">&copy; 2025 Livre d'or - Tous droits réservés.</p>
    </footer>
</body> 
</html>
