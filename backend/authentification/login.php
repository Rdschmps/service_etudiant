<?php
require_once __DIR__ . '/../common/Database.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use \Firebase\JWT\JWT;

class Login {
    private $db;
    private $secretKey = 'QWxhZGRpbjpvcGVuIHNlc2FtZQ=='; // Remplace par une clé secrète sécurisée

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function authenticate($email, $password) {
        try {
            // Rechercher l'utilisateur par email
            $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password_hash'])) {
                // Générer le token JWT
                $payload = [
                    'user_id' => $user['id'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'iat' => time(),
                    'exp' => time() + 3600 // Expiration dans 1 heure
                ];

                $token = JWT::encode($payload, $this->secretKey, 'HS256');

                // Retourner le token au frontend
                header('Content-Type: application/json');
                echo json_encode(['message' => 'Connexion réussie, vous allez être redirigé', 'token' => $token]);
            } else {
                header('Content-Type: application/json');
                echo json_encode(['error' => 'Email ou mot de passe incorrect.']);
            }
        } catch (PDOException $e) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Erreur lors de la connexion : ' . $e->getMessage()]);
        }
    }
}

// Vérifier si les données sont envoyées via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;

    if ($email && $password) {
        $login = new Login();
        $login->authenticate($email, $password);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Veuillez remplir tous les champs.']);
    }
}
