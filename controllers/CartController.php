<?php

require_once BASE_PATH . '/controllers/BaseController.php';
require_once BASE_PATH . '/models/Product.php';
require_once BASE_PATH . '/models/Sale.php';

class CartController extends BaseController
{
    public function view(): void
    {
        $cartItems = $this->buildCartItems();
        $success = getFlash('success');
        $error = getFlash('error');
        $this->render('store/cart.php', [
            'items' => $cartItems['items'],
            'total' => $cartItems['total'],
            'success' => $success,
            'error' => $error,
        ]);
    }

    public function add(): void
    {
        $productId = (int)($_POST['product_id'] ?? 0);
        $quantity = max(1, (int)($_POST['quantity'] ?? 1));
        $product = Product::find($productId);

        if (!$product) {
            setFlash('error', 'El producto no existe.');
            redirect(BASE_URL . 'index.php');
        }

        if ((int)$product['stock'] <= 0) {
            setFlash('error', 'Lo sentimos, este producto está agotado.');
            redirect(BASE_URL . 'index.php');
        }

        $cart = $this->getCart();
        $currentQty = $cart[$productId] ?? 0;
        $newQty = min($currentQty + $quantity, (int)$product['stock']);

        if ($newQty === $currentQty) {
            setFlash('error', 'No hay stock suficiente para agregar más unidades.');
            redirect(BASE_URL . 'index.php?action=cart');
        }

        $cart[$productId] = $newQty;
        $this->saveCart($cart);
        setFlash('success', 'Producto agregado al carrito.');
        redirect(BASE_URL . 'index.php?action=cart');
    }

    public function update(): void
    {
        $quantities = $_POST['quantities'] ?? [];
        $cart = $this->getCart();

        foreach ($quantities as $productId => $qty) {
            $productId = (int)$productId;
            $qty = max(0, (int)$qty);
            if (!isset($cart[$productId])) {
                continue;
            }
            if ($qty === 0) {
                unset($cart[$productId]);
                continue;
            }
            $product = Product::find($productId);
            if ($product) {
                $cart[$productId] = min($qty, (int)$product['stock']);
            }
        }

        $this->saveCart($cart);
        setFlash('success', 'Carrito actualizado.');
        redirect(BASE_URL . 'index.php?action=cart');
    }

    public function remove(): void
    {
        $productId = (int)($_POST['product_id'] ?? 0);
        $cart = $this->getCart();
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            $this->saveCart($cart);
            setFlash('success', 'Producto eliminado del carrito.');
        }
        redirect(BASE_URL . 'index.php?action=cart');
    }

    public function clear(): void
    {
        $this->emptyCart();
        setFlash('success', 'El carrito se vació correctamente.');
        redirect(BASE_URL . 'index.php?action=cart');
    }

    public function checkout(): void
    {
        $cart = $this->getCart();
        if (empty($cart)) {
            setFlash('error', 'No hay productos en el carrito.');
            redirect(BASE_URL . 'index.php?action=cart');
        }

        $pdo = getPDO();
        $pdo->beginTransaction();

        try {
            foreach ($cart as $productId => $qty) {
                $stmt = $pdo->prepare('SELECT * FROM productos WHERE id = :id FOR UPDATE');
                $stmt->execute(['id' => $productId]);
                $product = $stmt->fetch();

                if (!$product || (int)$product['stock'] < $qty) {
                    $pdo->rollBack();
                    setFlash('error', 'No hay stock suficiente para completar la compra.');
                    redirect(BASE_URL . 'index.php?action=cart');
                }

                $newStock = (int)$product['stock'] - $qty;
                $update = $pdo->prepare('UPDATE productos SET stock = :stock, fecha_actualizacion = NOW() WHERE id = :id');
                $update->execute(['stock' => $newStock, 'id' => $productId]);

                $total = $qty * (float)$product['precio'];
                Sale::create($productId, $qty, $total);
            }

            $pdo->commit();
        } catch (Throwable $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            throw $e;
        }

        $this->emptyCart();
        setFlash('success', '¡Compra realizada con éxito! Gracias por tu pedido.');
        redirect(BASE_URL . 'index.php');
    }

    private function getCart(): array
    {
        return $_SESSION['cart'] ?? [];
    }

    private function saveCart(array $cart): void
    {
        $_SESSION['cart'] = $cart;
    }

    private function emptyCart(): void
    {
        unset($_SESSION['cart']);
    }

    private function buildCartItems(): array
    {
        $cart = $this->getCart();
        $items = [];
        $total = 0.0;

        foreach ($cart as $productId => $qty) {
            $product = Product::find((int)$productId);
            if (!$product) {
                continue;
            }

            $lineTotal = $qty * (float)$product['precio'];
            $items[] = [
                'product' => $product,
                'quantity' => $qty,
                'line_total' => $lineTotal,
            ];
            $total += $lineTotal;
        }

        return ['items' => $items, 'total' => $total];
    }
}
