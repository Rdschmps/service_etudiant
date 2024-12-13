<?php
header('Content-Type: application/json');
session_start();

// Récupérer l'URL demandée
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
error_log("URI demandée : " . $uri); // Log pour vérifier l'URL

// Définir les routes vers les microservices
switch (true) {
    case strpos($uri, '/service_etudiant/backend/gateway.php/api/auth/') === 0:
        error_log("Routage vers authentification");
        require_once __DIR__ . '/authentification/' . basename($uri);
        break;

    case strpos($uri, '/service_etudiant/backend/gateway.php/api/announcements/') === 0:
        error_log("Routage vers announcements");
        require_once __DIR__ . '/announcements/' . basename($uri);
        break;

    default:
        http_response_code(404);
        echo json_encode(['error' => 'Route non trouvée']);
        error_log("Route non trouvée");
        break;
}
?>
