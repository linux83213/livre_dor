<?php

require_once __DIR__ . '/../classes/Database.php';

// Vérifie si l'utilisateur est connecté, sinon redirige vers la page de connexion
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?page=login");
    exit();
} 

// Crée une instance de Database
$db = new Database('localhost', 'livre_or', 'root', '');

// Récupérer le nom d'utilisateur pour l'affichage
$user_query = "SELECT username FROM users WHERE id = :id";
$user_args = [':id' => [$_SESSION['user_id'], PDO::PARAM_INT]];
$user_result = $db->readOne($user_query, $user_args);
$username = $user_result ? $user_result['username'] : "utilisateur";

$message = "";

// Traite le formulaire lorsqu'il est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifie si le champ commentaire n'est pas vide
    if (!empty($_POST['comment'])) {
        // Récupère le commentaire et l'ID utilisateur
        $comment = htmlspecialchars($_POST['comment']); // Sécurise le commentaire
        $user_id = $_SESSION['user_id'];
        
        // Avant insertion
        $query = "INSERT INTO comments (user_id, comment, date) VALUES (:user_id, :comment, NOW())";
        $args = [
            ':user_id' => [$_SESSION['user_id'], PDO::PARAM_INT],
            ':comment' => [$comment, PDO::PARAM_STR]
        ];

    // Ajoute un débogage
        try {
            // Vérifie la connexion à la base de données
            if (!$db) {
                throw new Exception("Connexion à la base de données échouée");
            }

            // Exécute la requête
            $result = $db->create($query, $args);

            // Vérifie si l'insertion a réussi
            if ($result) {
                $message = "Commentaire ajouté avec succès!";
                header("Location: index.php?page=livre-or");
                exit();
            } else {
                // Récupère les erreurs potentielles
                $message = "Erreur d'insertion du commentaire";
            }
        } catch (Exception $e) {
            $message = "Erreur : " . $e->getMessage();
        }
    } else {
        $message = "Veuillez entrer un commentaire.";
    }
}

?>


<section class="comment-section">
    <h2>Bonjour, <?= htmlspecialchars($username); ?>!</h2>
    <h3>Ajouter un commentaire</h3>

    <?php if ($message): ?>
        <p><?= htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form action="" method="post" id="comment-form">
        <label for="comment">Message :</label>
        <textarea id="comment" name="comment" required></textarea>
        <input type="submit">
    </form>
</section>

