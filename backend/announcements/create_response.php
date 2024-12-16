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
    $secretKey = 'QWxhZGRpbjpvcGVuIHNlc2FtZQ=='; // Utilise ta clé secrète sécurisée

    try {
        $decoded = JWT::decode($token, new Key($secretKey, 'HS256'));
        $userId = $decoded->user_id;

        class Response {
            private $db;

            public function __construct() {
                $this->db = Database::getInstance();
            }

            public function create($userId, $postId, $responseText) {
                try {
                    // Insérer la réponse
                    $stmt = $this->db->prepare("INSERT INTO responses (user_id, post_id, response_text) VALUES (:user_id, :post_id, :response_text)");
                    $stmt->execute([
                        ':user_id' => $userId,
                        ':post_id' => $postId,
                        ':response_text' => $responseText
                    ]);

                    // Ajouter 1 point à l'utilisateur qui répond
                    $stmt = $this->db->prepare("UPDATE users SET points = points + 1 WHERE id = :user_id");
                    $stmt->execute([':user_id' => $userId]);

                    echo "Réponse ajoutée avec succès ! Vous avez gagné 1 point.";
                } catch (PDOException $e) {
                    echo "Erreur lors de l'ajout de la réponse : " . $e->getMessage();
                }
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postId = $_POST['post_id'] ?? null;
            $responseText = $_POST['response_text'] ?? null;

            if ($postId && $responseText) {
                $response = new Response();
                $response->create($userId, $postId, $responseText);
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
?>
