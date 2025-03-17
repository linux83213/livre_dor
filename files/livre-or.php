<?php

    require_once __DIR__ . '/../classes/Database.php';
    require_once __DIR__ . '/../classes/User.php';
    require_once __DIR__ . '/../classes/Comment.php';

    // Crée instance de Database
    $db = new Database('localhost', 'livre_or', 'root', '');

    // Crée instance de la classe Comment
    $comment = new Comment($db);

    // Si aucune recherche, récupère tous les commentaires
    $comments = $comment->getAllComments();

    // Vérifie si une recherche a été effectuée
    $search = isset($_POST['search']) ? $_POST['search'] : '';

    if ($search) {
        // Effectue la recherche de commentaires
        $comments = $comment->searchComments($search);
    }

    // Nombre de commentaires par page
    $commentairesParPage = 3;

    // Récupération de la page actuelle
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($page < 1) $page = 1;

    // Calcul de l'offset
    $offset = ($page - 1) * $commentairesParPage;

    // Nombre total de commentaires
    $totalCommentaires = $db->readColumn("SELECT COUNT(*) FROM comments", []);
    $totalPages = ceil($totalCommentaires / $commentairesParPage);

    // Vérification si la page demandée existe
    if ($page > $totalPages) $page = $totalPages;

    // Récupération des commentaires avec pagination
    $commentaires = $db->readAll(
        "SELECT * FROM comments ORDER BY date DESC LIMIT ?, ?", 
        [$offset, $commentairesParPage]
);

?>

<section class="guestbook-container">
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
    <!-- Liens de pagination -->
    <div class="pagination">
    <?php if ($page > 1): ?>
        <a href="livre-or.php?page=<?= $page - 1 ?>">⬅️ Précédent</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="livre-or.php?page=<?= $i ?>" <?= ($i === $page) ? 'style="font-weight:bold;"' : '' ?>><?= $i ?></a>
    <?php endfor; ?>

    <?php if ($page < $totalPages): ?>
        <a href="livre-or.php?page=<?= $page + 1 ?>">Suivant ➡️</a>
    <?php endif; ?>
</div>
</section>
