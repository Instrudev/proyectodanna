<?php
require_once __DIR__ . '/../config.php';
require_once BASE_PATH . '/controllers/ProductController.php';

$action = $_GET['action'] ?? 'home';
$controller = new ProductController();

if ($action === 'buy' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->buy();
} else {
    $controller->home();
}
