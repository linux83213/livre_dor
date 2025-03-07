<?php

require_once('./classes/Database.php');
require_once('./classes/User.php');

// Instance de la classe Database
$db = new Database('localhost', 'livre_or', 'root', '');

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupère et sécurise les données du formulaire
    $username = htmlspecialchars(trim($_POST['username']));
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = :username";
    $userData = $db->readOne($query, [':username' => [$username, PDO::PARAM_STR]]);

    if ($userData) {
        // Crée l'instance de User avec l'ID récupéré
        $user = new User($db, $userData['id']);
        
        // Vérifie le mot de passe
        if (password_verify($password, $userData['password'])) {
            session_regenerate_id();
            $_SESSION['user_id'] = $userData['id'];
            header('Location: ' . BASE_PATH . '/files/profil.php');
            exit();
        } else {
            $message = 'Mauvais identifiants';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inconsolata:wght@200..900&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= BASE_PATH ?>/assets/css/index.css">
    <title>Connexion</title>
</head>
<body>
    <main>
        <section class="login-container">
            <h2 class="login-title">Connexion</h2>
            <?php if (!empty($message)): ?>
                <p><?= htmlspecialchars($message) ?></p>
            <?php endif; ?>
            <form action="profil.php" method="post" id="login-form">
                <img src="./assets/images/logo.png" alt="logo" class="logo-form">
                <label for="username">Nom d'utilisateur:</label>
                <input type="text" id="username" name="username">
                <label for="password">Mot de passe:</label>
                <input type="password" id="password" name="password">
                <input type="submit" name="submit" value="Se connecter">
            </form>
        </section>
    </main>
</body>
</html>