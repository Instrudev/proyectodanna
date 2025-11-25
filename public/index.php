<?php
require_once __DIR__ . '/../config.php';
require_once BASE_PATH . '/controllers/ProductController.php';
require_once BASE_PATH . '/controllers/CartController.php';

$action = $_GET['action'] ?? 'home';
$productController = new ProductController();
$cartController = new CartController();

switch ($action) {
    case 'add_to_cart':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cartController->add();
        }
        break;
    case 'cart':
        $cartController->view();
        break;
    case 'update_cart':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cartController->update();
        }
        break;
    case 'remove_from_cart':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cartController->remove();
        }
        break;
    case 'clear_cart':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cartController->clear();
        }
        break;
    case 'checkout':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cartController->checkout();
        }
        break;
    default:
        $productController->home();
        break;
}
