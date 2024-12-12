<?php
require_once '../common/Database.php';

class Response {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getResponsesByPostId($postId) {
        try {
            $stmt = $this->db->prepare("
                SELECT responses.id, responses.response_text, responses.created_at, users.username
                FROM responses
                JOIN users ON responses.user_id = users.id
                WHERE responses.post_id = :post_id
                ORDER BY responses.created_at ASC
            ");
            $stmt->execute([':post_id' => $postId]);
            $responses = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Retourner les réponses au format JSON
            header('Content-Type: application/json');
            echo json_encode($responses);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Erreur lors de la récupération des réponses : ' . $e->getMessage()]);
        }
    }
}

// Vérifier si le paramètre post_id est présent dans l'URL
if (isset($_GET['post_id']) && is_numeric($_GET['post_id'])) {
    $postId = intval($_GET['post_id']);
    $response = new Response();
    $response->getResponsesByPostId($postId);
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Paramètre post_id manquant ou invalide.']);
}
?>
