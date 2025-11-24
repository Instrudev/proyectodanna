<?php

require_once BASE_PATH . '/config.php';

class AdminUser
{
    public static function findByUsername(string $username): ?array
    {
        $stmt = getPDO()->prepare('SELECT * FROM usuarios_admin WHERE usuario = :usuario');
        $stmt->execute(['usuario' => $username]);
        $user = $stmt->fetch();
        return $user ?: null;
    }
}

