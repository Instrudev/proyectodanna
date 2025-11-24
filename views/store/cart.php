<section class="food_section layout_padding" id="cart">
  <div class="container">
    <div class="heading_container heading_center mb-4">
      <h2>Tu carrito</h2>
      <p>Revisa los productos que agregaste antes de finalizar la compra.</p>
    </div>

    <?php if (!empty($success)): ?>
      <div class="alert alert-success" role="alert"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
      <div class="alert alert-danger" role="alert"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if (count($items) === 0): ?>
      <div class="text-center">
        <p class="lead">Tu carrito está vacío.</p>
        <a href="<?= BASE_URL ?>index.php#productos" class="btn btn-primary">Seguir comprando</a>
      </div>
    <?php else: ?>
      <form action="<?= BASE_URL ?>index.php?action=update_cart" method="POST" class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Producto</th>
              <th>Precio</th>
              <th>Cantidad</th>
              <th>Total</th>
              <th class="text-right">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($items as $item): ?>
              <?php $product = $item['product']; ?>
              <tr>
                <td class="align-middle">
                  <div class="d-flex align-items-center">
                    <img src="<?= $baseUrl . htmlspecialchars($product['imagen']) ?>" alt="<?= htmlspecialchars($product['nombre']) ?>" class="mr-3" style="width: 70px; height: 70px; object-fit: cover;">
                    <div>
                      <strong><?= htmlspecialchars($product['nombre']) ?></strong>
                      <div class="text-muted small">Stock disponible: <?= (int)$product['stock'] ?></div>
                    </div>
                  </div>
                </td>
                <td class="align-middle">$<?= number_format((float)$product['precio'], 2) ?></td>
                <td class="align-middle" style="max-width: 120px;">
                  <input type="number" name="quantities[<?= (int)$product['id'] ?>]" value="<?= (int)$item['quantity'] ?>" min="0" class="form-control" />
                </td>
                <td class="align-middle">$<?= number_format((float)$item['line_total'], 2) ?></td>
                <td class="align-middle text-right">
                  <button type="submit" formaction="<?= BASE_URL ?>index.php?action=remove_from_cart" formmethod="POST" name="product_id" value="<?= (int)$product['id'] ?>" class="btn btn-sm btn-outline-danger">Eliminar</button>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
          <div class="mb-2">
            <a href="<?= BASE_URL ?>index.php#productos" class="btn btn-secondary">Seguir comprando</a>
            <button type="submit" class="btn btn-info">Actualizar cantidades</button>
            <button type="submit" formaction="<?= BASE_URL ?>index.php?action=clear_cart" formmethod="POST" class="btn btn-outline-danger ml-2" onclick="return confirm('¿Vaciar el carrito?');">Vaciar carrito</button>
          </div>
          <div class="text-right">
            <h4>Total: $<?= number_format((float)$total, 2) ?></h4>
            <button type="submit" formaction="<?= BASE_URL ?>index.php?action=checkout" formmethod="POST" class="btn btn-primary btn-lg mt-2">Finalizar compra</button>
          </div>
        </div>
      </form>
    <?php endif; ?>
  </div>
</section>
