<?php

class Comment
{
    private $db;

    // Constructeur pour l'initialisation de la base de données
    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    // Récupère tous les commentaires
    public function getAllComments()
    {
        $sql = "SELECT comments.id AS comment_id, comments.comment, comments.date, comments.user_id, 
                users.id AS user_id, users.username
                FROM comments
                INNER JOIN users ON comments.user_id = users.id
                ORDER BY comments.date DESC";
        return $this->db->readAll($sql, []);
    }

    // Récupère un commentaire par son ID
    public function getCommentById($commentId)
    {
        $sql = "SELECT comments.id AS comment_id, comments.comment, comments.date, comments.user_id, 
                users.id AS user_id, users.username
                FROM comments
                INNER JOIN users ON comments.user_id = users.id
                WHERE comments.id = :comment_id";
        
        $params = [':comment_id' => [$commentId, PDO::PARAM_INT]];
        return $this->db->readOne($sql, $params);
    }

    // Recherche des commentaires par texte
    public function searchComments($search)
    {
        $search = htmlspecialchars($search);
        $sql = 'SELECT comments.id AS comment_id, comments.comment, comments.date, comments.user_id, 
                users.id AS user_id, users.username
                FROM comments
                INNER JOIN users ON comments.user_id = users.id
                WHERE comments.comment LIKE :search
                ORDER BY comments.date DESC';
        
        $params = [':search' => ["%" . $search . "%", PDO::PARAM_STR]];
        return $this->db->readAll($sql, $params);
    }
}
?>
