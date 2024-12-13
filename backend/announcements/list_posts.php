<?php
require_once __DIR__ . '/../common/Database.php';

class Post {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAllPosts() {
        try {
            $stmt = $this->db->query("
                SELECT posts.id, posts.title, posts.description, posts.created_at, users.username 
                FROM posts
                JOIN users ON posts.user_id = users.id
                ORDER BY posts.created_at DESC
            ");
            $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Retourner les posts au format JSON
            header('Content-Type: application/json');
            echo json_encode($posts);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Erreur lors de la récupération des posts : ' . $e->getMessage()]);
        }
    }
}

// Créer une instance de la classe Post et récupérer les posts
$post = new Post();
$post->getAllPosts();
?>
