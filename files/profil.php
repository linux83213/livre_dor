<?php

if (!isset($_SESSION['id'])) {
    header('Location: index.php?page=login');
    exit;
}
?>

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
