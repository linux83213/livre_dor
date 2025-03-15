<?php

    require_once('./classes/Database.php');
    require_once('./classes/User.php');

    // Crée instance de Database
    $db = new Database('localhost', 'livre_or', 'root', '');

    // Vérifier si une recherche a été effectuée
    $search = isset($_POST['search']) ? $_POST['search'] : '';
    $whereConditions = [];
    $params = [];
    
    if ($search) {
        // Décompose le mot de recherche en lettres individuelles
        $letters = str_split($search);
    
        // Créer des conditions LIKE pour chaque lettre
        foreach ($letters as $letter) {
            $whereConditions[] = "comments.comment LIKE ?";
            $params[] = "%" . $letter . "%";
        }
    
        // Rejoindre les conditions avec "OR" pour que l'une ou l'autre lettre soit présente
        $whereSql = implode(" OR ", $whereConditions);
    
        // Construire la requête SQL avec la condition dynamique
        $sql = "SELECT comments.id AS comment_id, comments.comment, comments.date, comments.user_id, 
                users.id AS user_id, users.username
                FROM comments
                INNER JOIN users ON comments.user_id = users.id
                WHERE " . htmlspecialchars($whereSql) . "
                ORDER BY comments.date DESC";
    
        // Exécuter la requête avec les paramètres
        $comments = $db->readAll($sql, $params);
    } else {
        // Si aucune recherche, récupérer tous les commentaires
        $sql = "SELECT comments.id AS comment_id, comments.comment, comments.date, comments.user_id, 
                users.id AS user_id, users.username
                FROM comments
                INNER JOIN users ON comments.user_id = users.id
                ORDER BY comments.date DESC";
        $comments = $db->readAll($sql, []);
    }
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
            <form action="" method="post" id="search-form">
                <input type="search" name="search" id="search" placeholder="Rechercher un commentaire">
                <input type="submit" id="search-btn" value="Rechercher">
            </form>
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
