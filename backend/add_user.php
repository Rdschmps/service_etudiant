<?php
require_once 'common/Database.php';

class User {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function addUser($username, $email, $password) {
        try {
            // Préparer la requête pour insérer un utilisateur
            $stmt = $this->db->prepare("
                INSERT INTO users (username, email, password_hash) 
                VALUES (:username, :email, :password_hash)
            ");

            // Hachage sécurisé du mot de passe
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            // Exécuter la requête
            $stmt->execute([
                ':username' => $username,
                ':email' => $email,
                ':password_hash' => $passwordHash,
            ]);

            echo "Utilisateur ajouté avec succès !";
        } catch (PDOException $e) {
            echo "Erreur lors de l'ajout de l'utilisateur : " . $e->getMessage();
        }
    }
}

// Tester l'ajout d'un utilisateur
$user = new User();
$user->addUser("test1655", "test.1655@example.com", "1655");
?>
