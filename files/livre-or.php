<?php

    require_once('./classes/Database.php');
    require_once('./classes/User.php');

    // Crée instance de Database
    $db = new Database('localhost', 'livre_or', 'root', '');

    // Requête pour récupérer les commentaires avec l'ID de l'utilisateur
    // Ajout d'un ORDER BY pour trier par date décroissante
    $sql = "SELECT comments.id  AS comment_id, comments.comment, comments.date, comments.user_id, 
        users.id AS user_id, users.username
        FROM comments
        INNER JOIN users ON comments.user_id = users.id
        ORDER BY comments.date DESC";
    $comments = $db->readAll($sql, []); // Récupère tous les commentaires

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/index.css">
    <title>Livre d'or</title>
</head>
<body>
    <section class="book-container">
        <h2>Tous les commentaires des utilisateurs</h2>
        <div class="comments">
            <?php
                // Affiche chaque commentaire et les informations associées
                if (is_array($comments) && count($comments) > 0) {
                    foreach ($comments as $row) {
                        // Crée une instance de User avec l'ID de l'utilisateur associé à chaque commentaire
                        $user = new User($db, $row['user_id']);
                        
                        // Récupère le nom d'utilisateur ou affiche "Utilisateur inconnu"
                        //$username = $user->getUsername() ?? "Utilisateur inconnu";  
                        
                        $date_format = date('d/m/Y', strtotime($row['date']));
                        //getDateRegistered(string $format = 'd/m/Y')

                        // Affiche informations
                        echo "<div class='comment'>";
                        //echo "<h3>" . htmlspecialchars($username) . "</h3>";
                        echo "<p>" . nl2br(htmlspecialchars($row['comment'])) . "</p>";// nl2br pour afficher les sauts de ligne
                        echo "<p><em>Posté le: " . $date_format . "</em></p>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>Aucun commentaire trouvé.</p>";
                }
            ?>
        </div>
    </section>
</body>
</html>
