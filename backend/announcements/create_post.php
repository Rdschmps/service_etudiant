<?php
//session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../common/Database.php';


class Post {
    private $db;

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

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo "Vous devez être connecté pour créer un post.";
    exit();
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? null;
    $description = $_POST['description'] ?? null;
    $userId = $_SESSION['user_id'];

    if ($title && $description) {
        $post = new Post();
        $post->create($userId, $title, $description);
    } else {
        echo "Veuillez remplir tous les champs.";
    }
}
?>
