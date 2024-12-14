<?php
//session_start();
require_once './common/Database.php';

class Login {
    private $db;

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
                // Création de la session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];

                // Sécuriser la session en régénérant l'ID
                session_regenerate_id(true);

                echo "Connexion réussie ! Bienvenue, " . htmlspecialchars($user['username']) . ", vous allez être redirigés.";
            } else {
                echo "Email ou mot de passe incorrect.";
            }
        } catch (PDOException $e) {
            echo "Erreur lors de la connexion : " . $e->getMessage();
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
        echo "Veuillez remplir tous les champs.";
    }
}
?>
