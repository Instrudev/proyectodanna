<?php

require_once BASE_PATH . '/config.php';

class Product
{
    public static function all(): array
    {
        $stmt = getPDO()->query('SELECT * FROM productos ORDER BY fecha_creacion DESC');
        return $stmt->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $stmt = getPDO()->prepare('SELECT * FROM productos WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $product = $stmt->fetch();
        return $product ?: null;
    }

    public static function create(array $data): int
    {
        $sql = 'INSERT INTO productos (nombre, descripcion, precio, stock, imagen, fecha_creacion, fecha_actualizacion)
                VALUES (:nombre, :descripcion, :precio, :stock, :imagen, NOW(), NOW())';
        $stmt = getPDO()->prepare($sql);
        $stmt->execute([
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'],
            'precio' => $data['precio'],
            'stock' => $data['stock'],
            'imagen' => $data['imagen'],
        ]);
        return (int) getPDO()->lastInsertId();
    }

    public static function update(int $id, array $data): void
    {
        $sql = 'UPDATE productos SET nombre = :nombre, descripcion = :descripcion, precio = :precio, stock = :stock, imagen = :imagen, fecha_actualizacion = NOW() WHERE id = :id';
        $stmt = getPDO()->prepare($sql);
        $stmt->execute([
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'],
            'precio' => $data['precio'],
            'stock' => $data['stock'],
            'imagen' => $data['imagen'],
            'id' => $id,
        ]);
    }

    public static function delete(int $id): void
    {
        $stmt = getPDO()->prepare('DELETE FROM productos WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }

    public static function decrementStock(int $id, int $quantity): bool
    {
        $pdo = getPDO();
        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare('SELECT stock FROM productos WHERE id = :id FOR UPDATE');
            $stmt->execute(['id' => $id]);
            $product = $stmt->fetch();
            if (!$product || (int)$product['stock'] < $quantity) {
                $pdo->rollBack();
                return false;
            }
            $newStock = (int)$product['stock'] - $quantity;
            $update = $pdo->prepare('UPDATE productos SET stock = :stock, fecha_actualizacion = NOW() WHERE id = :id');
            $update->execute(['stock' => $newStock, 'id' => $id]);
            $pdo->commit();
            return true;
        } catch (Throwable $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            throw $e;
        }
    }
}

