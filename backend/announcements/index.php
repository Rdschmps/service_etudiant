<?php
require_once '../common/Database.php';
require_once 'AnnouncementsController.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$controller = new AnnouncementsController();

switch ($uri) {
    case '/announcements':
        if ($method === 'GET') {
            $controller->getAnnouncements();
        } elseif ($method === 'POST') {
            $controller->createAnnouncement();
        }
        break;
    case '/announcements/{id}':
        if ($method === 'GET') {
            $controller->getAnnouncement($id);
        }
        break;
    default:
        http_response_code(404);
        echo json_encode(['message' => 'Not Found']);
}
