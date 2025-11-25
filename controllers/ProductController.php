<?php

require_once BASE_PATH . '/controllers/BaseController.php';
require_once BASE_PATH . '/models/Product.php';
require_once BASE_PATH . '/models/Sale.php';

class ProductController extends BaseController
{
    public function home(): void
    {
        $products = Product::all();
        $success = getFlash('success');
        $error = getFlash('error');
        $this->render('store/home.php', compact('products', 'success', 'error'));
    }

    public function buy(): void
    {
        $productId = (int)($_POST['product_id'] ?? 0);
        $quantity = 1;
        $product = Product::find($productId);

        if (!$product) {
            setFlash('error', 'El producto no existe.');
            redirect(BASE_URL . 'index.php');
        }

        if ((int)$product['stock'] <= 0) {
            setFlash('error', 'Lo sentimos, este producto está agotado.');
            redirect(BASE_URL . 'index.php');
        }

        $success = Product::decrementStock($productId, $quantity);
        if (!$success) {
            setFlash('error', 'No hay stock suficiente para completar la compra.');
            redirect(BASE_URL . 'index.php');
        }

        $total = $quantity * (float)$product['precio'];
        Sale::create($productId, $quantity, $total);
        setFlash('success', '¡Compra registrada con éxito! Gracias por tu pedido.');
        redirect(BASE_URL . 'index.php');
    }
}

