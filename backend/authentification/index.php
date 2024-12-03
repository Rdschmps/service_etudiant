<?php
require_once '../common/Database.php';
require_once 'AuthController.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$authController = new AuthController();

switch ($uri) {
    case '/login':
        if ($method === 'POST') {
            $authController->login();
        }
        break;
    case '/register':
        if ($method === 'POST') {
            $authController->register();
        }
        break;
    default:
        http_response_code(404);
        echo json_encode(['message' => 'Not Found']);
}
