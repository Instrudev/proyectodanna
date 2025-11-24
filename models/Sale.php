<?php

require_once BASE_PATH . '/config.php';

class Sale
{
    public static function create(int $productId, int $quantity, float $total): void
    {
        $sql = 'INSERT INTO ventas (producto_id, cantidad, total, fecha_venta) VALUES (:producto_id, :cantidad, :total, NOW())';
        $stmt = getPDO()->prepare($sql);
        $stmt->execute([
            'producto_id' => $productId,
            'cantidad' => $quantity,
            'total' => $total,
        ]);
    }
}

