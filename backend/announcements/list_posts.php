<?php
require_once __DIR__ . '/../common/Database.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

// Vérification du token JWT
$headers = getallheaders();
$authHeader = $headers['Authorization'] ?? null;

if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
    $token = $matches[1];
    $secretKey = 'QWxhZGRpbjpvcGVuIHNlc2FtZQ=='; // Remplace par ta clé secrète sécurisée

    try {
        $decoded = JWT::decode($token, new Key($secretKey, 'HS256'));
        $userId = $decoded->user_id;

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
    } catch (Exception $e) {
        http_response_code(401);
        echo json_encode(['error' => 'Accès non autorisé : ' . $e->getMessage()]);
    }
} else {
    http_response_code(401);
    echo json_encode(['error' => 'Token manquant ou invalide.']);
}
?>
