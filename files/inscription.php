<?php
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]); // isset verfiier pssword et username 
    $password = trim($_POST["password"]);
    
    if (empty($username) || empty($password)) {
        $error = "Tous les champs sont obligatoires.";
    } else {
        // Ici, vous pouvez ajouter la logique pour vérifier l'utilisateur en base de données.
        echo "Connexion réussie !";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="formulaire.css">
    <title>Connexion</title>
</head>
<body>
    <h2>Formulaire de connexion</h2>
    <?php if (!empty($error)) echo "<p style='color: red;'>$error</p>"; ?>
    <form action="" method="post">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" name="username" id="username" required>
        <br>
        <label for="password">Mot de passe :</label>
        <input type="password" name="password" id="password" required>
        <br>
        <button type="submit">Se connecter</button>
    </form>
</body>
</html>
