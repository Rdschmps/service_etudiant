<?php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch (true) {
    case strpos($uri, '/auth/') === 0:
        require '../authentication/index.php';
        break;
    case strpos($uri, '/announcements/') === 0:
        require '../announcements/index.php';
        break;
    case strpos($uri, '/points/') === 0:
        require '../points/index.php';
        break;
    default:
        http_response_code(404);
        echo json_encode(['message' => 'Invalid API call']);
}
