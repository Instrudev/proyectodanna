<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel Admin</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
  <style>
    body { background: #f7f7f7; }
    .navbar-brand { font-weight: bold; }
    .card { box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <a class="navbar-brand" href="<?= BASE_URL ?>admin/index.php">Admin Tienda</a>
  <div class="collapse navbar-collapse">
    <ul class="navbar-nav mr-auto">
      <?php if (!empty($_SESSION['admin_id'])): ?>
        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>admin/index.php">Productos</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>index.php" target="_blank">Ver tienda</a></li>
      <?php endif; ?>
    </ul>
    <ul class="navbar-nav ml-auto">
      <?php if (!empty($_SESSION['admin_username'])): ?>
        <li class="nav-item mr-3 text-white d-flex align-items-center">Bienvenido, <?= htmlspecialchars($_SESSION['admin_username']) ?></li>
        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>admin/index.php?action=logout">Salir</a></li>
      <?php endif; ?>
    </ul>
  </div>
</nav>
<div class="container mb-5">
