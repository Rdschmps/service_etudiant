<?php
require_once __DIR__ . '/../common/Database.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

class Post {
    private $db;
    private $secretKey = 'QWxhZGRpbjpvcGVuIHNlc2FtZQ=='; // Remplace par une clé secrète sécurisée

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function create($userId, $title, $description) {
        try {
            // Vérifier si l'utilisateur a au moins 1 point
            $stmt = $this->db->prepare("SELECT points FROM users WHERE id = :user_id");
            $stmt->execute([':user_id' => $userId]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && $user['points'] >= 1) {
                // Insérer le post
                $stmt = $this->db->prepare("INSERT INTO posts (user_id, title, description) VALUES (:user_id, :title, :description)");
                $stmt->execute([
                    ':user_id' => $userId,
                    ':title' => $title,
                    ':description' => $description
                ]);

                // Déduire 1 point à l'utilisateur
                $stmt = $this->db->prepare("UPDATE users SET points = points - 1 WHERE id = :user_id");
                $stmt->execute([':user_id' => $userId]);

                echo "Post créé avec succès ! 1 point a été déduit.";
            } else {
                echo "Vous n'avez pas assez de points pour créer un post.";
            }
        } catch (PDOException $e) {
            echo "Erreur lors de la création du post : " . $e->getMessage();
        }
    }
}

// Vérification du token JWT
$headers = getallheaders();
$authHeader = $headers['Authorization'] ?? null;

if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
    $token = $matches[1];
    $secretKey = 'QWxhZGRpbjpvcGVuIHNlc2FtZQ=='; // Utilise la même clé secrète que pour la génération du token

    try {
        $decoded = JWT::decode($token, new Key($secretKey, 'HS256'));
        $userId = $decoded->user_id;

        // Traitement du formulaire
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? null;
            $description = $_POST['description'] ?? null;

            if ($title && $description) {
                $post = new Post();
                $post->create($userId, $title, $description);
            } else {
                echo "Veuillez remplir tous les champs.";
            }
        }
    } catch (Exception $e) {
        http_response_code(401);
        echo "Accès non autorisé : " . $e->getMessage();
    }
} else {
    http_response_code(401);
    echo "Token manquant ou invalide.";
}
