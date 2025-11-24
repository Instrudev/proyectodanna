<?php
session_start();

// Base settings
if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__);
}
if (!defined('BASE_URL')) {
    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
    $scriptDir = str_replace('\\', '/', dirname($scriptName));
    $scriptDir = ($scriptDir === '/' || $scriptDir === '.') ? '' : rtrim($scriptDir, '/');

    // Normalize so that admin routes still point to the public asset root
    if (substr($scriptDir, -6) === '/admin') {
        $scriptDir = substr($scriptDir, 0, -6);
    }

    $calculatedBase = $scriptDir === '' ? '/' : $scriptDir . '/';
    define('BASE_URL', $calculatedBase);
}
if (!defined('ASSET_URL')) {
    define('ASSET_URL', BASE_URL);
}

// Database credentials
const DB_HOST = 'localhost';
const DB_NAME = 'tienda_online';
const DB_USER = 'root';
const DB_PASSWORD = '';

function getPDO(): PDO
{
    static $pdo;
    if (!$pdo) {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
        $pdo = new PDO($dsn, DB_USER, DB_PASSWORD, $options);
    }
    return $pdo;
}

function redirect(string $path): void
{
    header('Location: ' . $path);
    exit;
}

function setFlash(string $type, string $message): void
{
    $_SESSION['flash'][$type] = $message;
}

function getFlash(string $type): ?string
{
    if (isset($_SESSION['flash'][$type])) {
        $message = $_SESSION['flash'][$type];
        unset($_SESSION['flash'][$type]);
        return $message;
    }
    return null;
}

