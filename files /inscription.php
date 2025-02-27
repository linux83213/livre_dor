<?php
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $terms = isset($_POST["terms"]);
    
    if (empty($username) || empty($password) || empty($confirm_password)) {
        $error = "Tous les champs sont obligatoires.";
    } elseif ($password !== $confirm_password) {
        $error = "Les mots de passe ne correspondent pas.";
    } elseif (!$terms) {
        $error = "Vous devez accepter les conditions d'utilisation.";
    } else {
        // Ici, vous pouvez ajouter la logique pour enregistrer l'utilisateur en base de données.
        echo "Inscription réussie !";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="formulaire.css">
</head>
<body>
    <h2>Formulaire d'inscription</h2>
    <?php if (!empty($error)) echo "<p style='color: red;'>$error</p>"; ?>
    <form action="" method="post">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" name="username" id="username" required>
        <br>
        <label for="password">Mot de passe :</label>
        <input type="password" name="password" id="password" required>
        <br>
        <label for="confirm_password">Confirmez le mot de passe :</label>
        <input type="password" name="confirm_password" id="confirm_password" required>
        <br>
        <input type="checkbox" name="terms" id="terms">
        <label for="terms">J'accepte les conditions d'utilisation</label>
        <br>
        <button type="submit">S'inscrire</button>
    </form>
</body>
</html>
