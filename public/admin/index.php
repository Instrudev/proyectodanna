<?php
require_once __DIR__ . '/../../config.php';
require_once BASE_PATH . '/controllers/AdminController.php';

$controller = new AdminController();
$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'login':
        $controller->login();
        break;
    case 'logout':
        $controller->logout();
        break;
    case 'create':
        $controller->create();
        break;
    case 'edit':
        $controller->edit();
        break;
    case 'delete':
        $controller->delete();
        break;
    default:
        $controller->index();
        break;
}
