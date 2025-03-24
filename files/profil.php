<?php

require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/User.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?page=login');
    exit;
}

$db = new Database('localhost', 'livre_or', 'root', '');
$user = new User($db, $_SESSION['user_id']);

// Vérifie si un formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $success = false;

    // Mise à jour de l'email
    if (!empty($_POST['email'])) {
        $newEmail = trim($_POST['email']);
        if ($user->setEmail($newEmail)) {
            $success = true;
            $_SESSION['message'] = "Email mis à jour avec succès.";
        } else {
            $_SESSION['error'] = "Erreur lors de la mise à jour de l'email.";
        }
    }

    // Mise à jour du mot de passe
    if (!empty($_POST['old_password']) && !empty($_POST['new_password'])) {
        $oldPassword = trim($_POST['old_password']);
        $newPassword = trim($_POST['new_password']);

        if ($user->setPassword($oldPassword, $newPassword)) {
            $success = true;
            $_SESSION['message'] = "Mot de passe mis à jour avec succès.";
        } else {
            $_SESSION['error'] = "Erreur : mot de passe incorrect ou trop faible.";
        }
    }
     // Redirection avec un message
    header('Location: profil.php');
    exit;
}

// Récupérer le nom d'utilisateur pour l'affichage
$user_query = "SELECT username FROM users WHERE id = :id";
$user_args = [':id' => [$_SESSION['user_id'], PDO::PARAM_INT]];
$user_result = $db->readOne($user_query, $user_args);
$username = $user_result ? $user_result['username'] : "utilisateur";

?>

<section>
    <h1>Profil de <?= htmlspecialchars($username); ?></h1>
    <form action="" method="post">
        <label for="email">Nouvelle adresse email :</label>
        <input type="email" name="email" id="email" placeholder="Entrez votre nouvelle adresse email">
        <label for="old_password">Ancien mot de passe :</label>
        <input type="password" name="old_password" id="old_password" placeholder="Entrez votre ancien mot de passe">
        <label for="password">Nouveau mot de passe :</label>
        <input type="password" name="new_password" id="new_password" placeholder="Entrez votre nouveau mot de passe">
        <input type="submit" value="Mettre à jour">
    </form>
</section>
