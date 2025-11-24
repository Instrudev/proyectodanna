<?php

require_once BASE_PATH . '/controllers/BaseController.php';
require_once BASE_PATH . '/models/Product.php';
require_once BASE_PATH . '/models/AdminUser.php';

class AdminController extends BaseController
{
    private function requireLogin(): void
    {
        if (empty($_SESSION['admin_id'])) {
            redirect(BASE_URL . 'admin/index.php?action=login');
        }
    }

    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['usuario'] ?? '');
            $password = $_POST['password'] ?? '';
            $user = AdminUser::findByUsername($username);
            if ($user && password_verify($password, $user['password_hash'])) {
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['admin_username'] = $user['usuario'];
                redirect(BASE_URL . 'admin/index.php');
            }
            setFlash('error', 'Credenciales inválidas.');
        }
        $error = getFlash('error');
        $this->render('admin/login.php', compact('error'), ['layout/admin_header.php', 'layout/admin_footer.php']);
    }

    public function logout(): void
    {
        session_destroy();
        redirect(BASE_URL . 'admin/index.php?action=login');
    }

    public function index(): void
    {
        $this->requireLogin();
        $products = Product::all();
        $success = getFlash('success');
        $error = getFlash('error');
        $this->render('admin/products/index.php', compact('products', 'success', 'error'), ['layout/admin_header.php', 'layout/admin_footer.php']);
    }

    public function create(): void
    {
        $this->requireLogin();
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            [$validData, $errors] = $this->validateProduct($_POST, $_FILES['imagen'] ?? null);
            if (empty($errors)) {
                Product::create($validData);
                setFlash('success', 'Producto creado correctamente.');
                redirect(BASE_URL . 'admin/index.php');
            }
        }
        $this->render('admin/products/form.php', ['errors' => $errors], ['layout/admin_header.php', 'layout/admin_footer.php']);
    }

    public function edit(): void
    {
        $this->requireLogin();
        $id = (int)($_GET['id'] ?? 0);
        $product = Product::find($id);
        if (!$product) {
            setFlash('error', 'Producto no encontrado.');
            redirect(BASE_URL . 'admin/index.php');
        }
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            [$validData, $errors] = $this->validateProduct($_POST, $_FILES['imagen'] ?? null, $product['imagen']);
            if (empty($errors)) {
                Product::update($id, $validData);
                setFlash('success', 'Producto actualizado.');
                redirect(BASE_URL . 'admin/index.php');
            }
        }
        $this->render('admin/products/form.php', ['errors' => $errors, 'product' => $product], ['layout/admin_header.php', 'layout/admin_footer.php']);
    }

    public function delete(): void
    {
        $this->requireLogin();
        $id = (int)($_GET['id'] ?? 0);
        $product = Product::find($id);
        if (!$product) {
            setFlash('error', 'Producto no encontrado.');
        } else {
            Product::delete($id);
            setFlash('success', 'Producto eliminado.');
        }
        redirect(BASE_URL . 'admin/index.php');
    }

    private function validateProduct(array $input, ?array $imageFile, string $currentImage = ''): array
    {
        $errors = [];
        $nombre = trim($input['nombre'] ?? '');
        $descripcion = trim($input['descripcion'] ?? '');
        $precio = $input['precio'] ?? '';
        $stock = $input['stock'] ?? '';
        $imagen = $currentImage;

        if ($nombre === '') {
            $errors[] = 'El nombre es obligatorio.';
        }
        if ($descripcion === '') {
            $errors[] = 'La descripción es obligatoria.';
        }
        if (!is_numeric($precio) || (float)$precio < 0) {
            $errors[] = 'El precio debe ser un número positivo.';
        }
        if (!ctype_digit((string)$stock) || (int)$stock < 0) {
            $errors[] = 'El stock debe ser un número entero igual o mayor a 0.';
        }

        if ($imageFile && !empty($imageFile['name'])) {
            if ($imageFile['error'] === UPLOAD_ERR_OK) {
                $allowed = ['image/jpeg', 'image/png', 'image/gif'];
                if (!in_array($imageFile['type'], $allowed, true)) {
                    $errors[] = 'El formato de imagen no es válido.';
                } else {
                    $uploadDir = BASE_PATH . '/public/uploads/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
                    $extension = pathinfo($imageFile['name'], PATHINFO_EXTENSION);
                    $filename = uniqid('producto_', true) . '.' . $extension;
                    $destination = $uploadDir . $filename;
                    if (move_uploaded_file($imageFile['tmp_name'], $destination)) {
                        $imagen = 'uploads/' . $filename;
                    } else {
                        $errors[] = 'No se pudo guardar la imagen subida.';
                    }
                }
            } else {
                $errors[] = 'Error al subir la imagen.';
            }
        } elseif ($currentImage === '') {
            $errors[] = 'La imagen es obligatoria.';
        }

        $data = [
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'precio' => (float)$precio,
            'stock' => (int)$stock,
            'imagen' => $imagen,
        ];

        return [$data, $errors];
    }
}

