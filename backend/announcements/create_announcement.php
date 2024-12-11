<?php
session_start();
require_once '../common/Database.php';

class Announcement {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function create($userId, $title, $description) {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO announcements (user_id, title, description) 
                VALUES (:user_id, :title, :description)
            ");
            $stmt->execute([
                ':user_id' => $userId,
                ':title' => $title,
                ':description' => $description
            ]);

            echo "Annonce créée avec succès !";
        } catch (PDOException $e) {
            echo "Erreur lors de la création de l'annonce : " . $e->getMessage();
        }
    }
}

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo "Vous devez être connecté pour créer une annonce.";
    exit();
}

// Vérifier si les données sont envoyées via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? null;
    $description = $_POST['description'] ?? null;
    $userId = $_SESSION['user_id'];

    if ($title && $description) {
        $announcement = new Announcement();
        $announcement->create($userId, $title, $description);
    } else {
        echo "Veuillez remplir tous les champs.";
    }
}
?>
