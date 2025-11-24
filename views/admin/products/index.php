<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">Productos</h3>
  <a href="<?= BASE_URL ?>admin/index.php?action=create" class="btn btn-success"><i class="fas fa-plus mr-1"></i> Nuevo producto</a>
</div>
<?php if (!empty($success)): ?>
  <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>
<?php if (!empty($error)): ?>
  <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>
<div class="card">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Imagen</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($products) === 0): ?>
            <tr><td colspan="6" class="text-center">No hay productos cargados.</td></tr>
          <?php endif; ?>
          <?php foreach ($products as $product): ?>
            <tr>
              <td><?= (int)$product['id'] ?></td>
              <td><?= htmlspecialchars($product['nombre']) ?></td>
              <td>$<?= number_format((float)$product['precio'], 2) ?></td>
              <td><?= (int)$product['stock'] ?></td>
              <td>
                <?php if (!empty($product['imagen'])): ?>
                  <img src="<?= BASE_URL . htmlspecialchars($product['imagen']) ?>" alt="<?= htmlspecialchars($product['nombre']) ?>" style="width:60px;height:60px;object-fit:cover;">
                <?php endif; ?>
              </td>
              <td>
                <a href="<?= BASE_URL ?>admin/index.php?action=edit&id=<?= (int)$product['id'] ?>" class="btn btn-sm btn-primary">Editar</a>
                <a href="<?= BASE_URL ?>admin/index.php?action=delete&id=<?= (int)$product['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este producto?');">Eliminar</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
