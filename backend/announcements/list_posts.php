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

        class Post {
            private $db;

            public function __construct() {
                $this->db = Database::getInstance();
            }

            public function getAllPosts($category = null) {
                try {
                    // Construction de la requête SQL avec possibilité de filtrer par catégorie
                    $query = "SELECT posts.id, posts.title, posts.description, posts.category, posts.created_at, users.username 
                              FROM posts
                              JOIN users ON posts.user_id = users.id";

                    if ($category) {
                        $query .= " WHERE posts.category = :category";
                    }

                    $query .= " ORDER BY posts.created_at DESC";

                    // Préparation de la requête
                    $stmt = $this->db->prepare($query);

                    if ($category) {
                        $stmt->execute([':category' => $category]);
                    } else {
                        $stmt->execute();
                    }

                    // Récupération des résultats
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

        // Récupération de la catégorie depuis les paramètres GET
        $category = $_GET['category'] ?? null;

        // Créer une instance de la classe Post et récupérer les posts
        $post = new Post();
        $post->getAllPosts($category);
    } catch (Exception $e) {
        http_response_code(401);
        echo json_encode(['error' => 'Accès non autorisé : ' . $e->getMessage()]);
    }
} else {
    http_response_code(401);
    echo json_encode(['error' => 'Token manquant ou invalide.']);
}
?>
