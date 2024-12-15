<?php
session_start();
require_once '../common/Database.php';
require_once '../../vendor/autoload.php';

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

// Vérifier le token JWT
$headers = getallheaders();
$authHeader = $headers['Authorization'] ?? null;

if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
    $token = $matches[1];
    $secretKey = 'QWxhZGRpbjpvcGVuIHNlc2FtZQ=='; // Utilise une clé secrète sécurisée

    try {
        $decoded = JWT::decode($token, new Key($secretKey, 'HS256'));
        $userId = $decoded->user_id;

        // Connexion à la base de données
        $db = Database::getInstance();

        // Récupérer les informations de l'utilisateur
        $stmt = $db->prepare("SELECT username, email, points FROM users WHERE id = :user_id");
        $stmt->execute([':user_id' => $userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            header('Content-Type: application/json');
            echo json_encode([
                'username' => $user['username'],
                'email' => $user['email'],
                'points' => $user['points']
            ]);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Utilisateur non trouvé.']);
        }

    } catch (Exception $e) {
        http_response_code(401);
        echo json_encode(['error' => 'Accès non autorisé : ' . $e->getMessage()]);
    }
} else {
    http_response_code(401);
    echo json_encode(['error' => 'Token manquant ou invalide.']);
}
?>
