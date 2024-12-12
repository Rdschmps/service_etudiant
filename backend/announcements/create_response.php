<?php
session_start();
require_once '../common/Database.php';

class Response {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function create($postId, $userId, $responseText) {
        try {
            // Insérer la réponse
            $stmt = $this->db->prepare("INSERT INTO responses (post_id, user_id, response_text) VALUES (:post_id, :user_id, :response_text)");
            $stmt->execute([
                ':post_id' => $postId,
                ':user_id' => $userId,
                ':response_text' => $responseText
            ]);

            // Ajouter 1 point à l'utilisateur
            $stmt = $this->db->prepare("UPDATE users SET points = points + 1 WHERE id = :user_id");
            $stmt->execute([':user_id' => $userId]);

            echo "Réponse ajoutée avec succès ! 1 point vous a été attribué.";
        } catch (PDOException $e) {
            echo "Erreur lors de l'ajout de la réponse : " . $e->getMessage();
        }
    }
}

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo "Vous devez être connecté pour répondre à un post.";
    exit();
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postId = $_POST['post_id'] ?? null;
    $responseText = $_POST['response_text'] ?? null;
    $userId = $_SESSION['user_id'];

    if ($postId && $responseText) {
        $response = new Response();
        $response->create($postId, $userId, $responseText);
    } else {
        echo "Veuillez remplir tous les champs.";
    }
}
?>
