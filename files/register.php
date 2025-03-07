<?php

require_once('classes/Database.php');

$db = new Database('localhost', 'livre_or', 'root', '');

$message = '';// Affiche les erreurs de connexion

// Verifie que la requête est POST 
// Execute la condition que si le formulaire a bien été soumis 
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    //Récupération des données saisies
    $username = trim($_POST['username']);//Supprime les espaces inutiles
    $email = trim($_POST['email']);
    $password = ($_POST['password']);

    // Validation des entrées utilisateur.
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Email invalide';
    }elseif (strlen($username) < 3) {
        $message = 'Le nom d\'utilisateur doit contenir au moins 3 caractères.';
    } elseif (strlen($password) < 6) {
        $message = 'Le mot de passe doit contenir au moins 6 caractères.';
    }

    // Si les données sont valides
    if (empty($message)) {
        // Hâche le mot de passe
        $hashedPassword = password_hash($password, PASSWORD_ARGON2ID);

        // Prépare la requête d'insertion
        $query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        
        // Liaison des paramètres avec les valeurs
        $args = [
            ':username' => [$username, PDO::PARAM_STR],
            ':email' => [$email, PDO::PARAM_STR],
            ':password' => [$hashedPassword, PDO::PARAM_STR]
        ];
        
        // Exécute la requête d'insertion
        try {
            if ($db->create($query, $args)) {
                // Redirige vers la page de connexion si l'inscription est réussie
                $message = 'Inscription réussie!';
                header('Location: ./files/login.php');
                exit();
            } else {
                $message = 'Erreur lors de l\'inscription, veuillez réessayer.';
            }
        } catch (Exception $e) {
            // Si une exception se produit lors de la connexion ou de l'exécution, la capturer
            $message = 'Erreur interne: ' . $e->getMessage();
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
    <link rel="stylesheet" href="./assets/css/index.css">
    <title>Inscription</title>
</head>
<body>
    <main>
        <section class="register-container">
            <h2>S'inscrire</h2>
            <?php if (!empty($message)) : ?>
                <p><?= htmlspecialchars($message); ?></p>
            <?php endif; ?>
            <form method=POST action="" id="register-form">
                <img src="./assets/images/logo.png" alt="logo" class="logo">
                <label for="username">Nom d'utilisateur</label>
                <input 
                    type="text" 
                    id="username" 
                    name="username" 
                    placeholder="Entrez votre nom d'utilisateur"
                    required
                /></br>
                <label for="email">Adresse mail</label>
                <input
                    type=email
                    id="email" 
                    name="email" 
                    placeholder="Entrez votre adresse mail"
                    required
                /></br>
                <label for="password">Mot de passe</label>
                <input
                    type=password
                    id="password" 
                    name="password" 
                    placeholder="Entrez votre mot de passe"
                    required
                /></br>
                <input 
                    type="submit" 
                    name="submit" 
                    value="S'inscrire" 
                    class="register-button" 
                />
                <p class="box-register">
                    Déjà inscrit ? 
                    <a href="./files/login.php?page=login">Connectez-vous ici</a>
                </p>
                <p class="terms-of-use">
                    En créant un compte, vous acceptez nos Conditions d'utilisation. <br>
                    Découvrez comment nous traitons vos données dans <u>notre Politique de confidentialité.</u>
                </p>
            </form>
        </section>
    </main>
</body>
</html>