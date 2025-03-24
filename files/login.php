<?php

require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/User.php';

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
            header('Location: index.php');
            exit();
        } else {
            $message = 'Mauvais identifiants';
        }
    }
}
?>


<section class="login-container">
    <h2 class="login-title">Connexion</h2>
    <?php if (!empty($message)): ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
    <form action="" method="post" id="login-form">
        <img src="./assets/images/logo.png" alt="logo" class="logo-form">
        <label for="username">Nom d'utilisateur:</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required>
        <input type="submit" name="submit" value="Se connecter">
    </form>
</section>
