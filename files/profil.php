<?php

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="./commentaires.php">Ajouter un message</a></li>
                <li><a href="./logout.php">Déconnexion</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section>
            <h1>Profil de <?php echo $_SESSION['username']; ?></h1>
            <p>Adresse email : <?php echo $_SESSION['email']; ?></p>
            <form action="update.php" method="post">
                <label for="email">Nouvelle adresse email :</label>
                <input type="email" name="email" id="email">
                <label for="password">Nouveau mot de passe :</label>
                <input type="password" name="password" id="password">
                <input type="submit" value="Mettre à jour">
        </section>
    </main>
</body>
</html>