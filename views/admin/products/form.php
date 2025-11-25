<?php $isEdit = isset($product); ?>
<div class="card">
  <div class="card-body">
    <h4 class="card-title mb-4"><?= $isEdit ? 'Editar producto' : 'Crear producto' ?></h4>
    <?php if (!empty($errors)): ?>
      <div class="alert alert-danger">
        <ul class="mb-0">
          <?php foreach ($errors as $err): ?>
            <li><?= htmlspecialchars($err) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>
    <form method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" class="form-control" required value="<?= htmlspecialchars($product['nombre'] ?? '') ?>">
      </div>
      <div class="form-group">
        <label for="descripcion">Descripción</label>
        <textarea id="descripcion" name="descripcion" class="form-control" rows="4" required><?= htmlspecialchars($product['descripcion'] ?? '') ?></textarea>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="precio">Precio</label>
          <input type="number" step="0.01" min="0" id="precio" name="precio" class="form-control" required value="<?= htmlspecialchars($product['precio'] ?? '') ?>">
        </div>
        <div class="form-group col-md-6">
          <label for="stock">Stock</label>
          <input type="number" min="0" id="stock" name="stock" class="form-control" required value="<?= htmlspecialchars($product['stock'] ?? '') ?>">
        </div>
      </div>
      <div class="form-group">
        <label for="imagen">Imagen <?= $isEdit && !empty($product['imagen']) ? '(dejar vacío para mantener)' : '' ?></label>
        <input type="file" name="imagen" id="imagen" class="form-control-file" <?= $isEdit ? '' : 'required' ?> accept="image/*">
        <?php if ($isEdit && !empty($product['imagen'])): ?>
          <div class="mt-2">
            <img src="<?= BASE_URL . htmlspecialchars($product['imagen']) ?>" alt="actual" style="width:120px;height:120px;object-fit:cover;">
          </div>
        <?php endif; ?>
      </div>
      <button type="submit" class="btn btn-primary">Guardar</button>
      <a href="<?= BASE_URL ?>admin/index.php" class="btn btn-secondary">Cancelar</a>
    </form>
  </div>
</div>
