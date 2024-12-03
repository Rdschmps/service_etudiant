<?php
require_once 'common/Database.php';

class User {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function addUser($username, $email, $password) {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO users (username, email, password_hash) 
                VALUES (:username, :email, :password_hash)
            ");

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $stmt->execute([
                ':username' => $username,
                ':email' => $email,
                ':password_hash' => $passwordHash
            ]);

            echo "Utilisateur créé avec succès !";
        } catch (PDOException $e) {
            echo "Erreur lors de la création de l'utilisateur : " . $e->getMessage();
        }
    }
}

// Vérifie si les données sont envoyées via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? null;
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;

    if ($username && $email && $password) {
        $user = new User();
        $user->addUser($username, $email, $password);
    } else {
        echo "Tous les champs sont obligatoires.";
    }
}
?>
