    <section class="slider_section ">
      <div id="customCarousel1" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="container ">
              <div class="row">
                <div class="col-md-7 col-lg-6 ">
                  <div class="detail-box">
                    <h1>
                      Bienvenido a tu tienda online
                    </h1>
                    <p>
                      Explora nuestro catálogo, agrega tus productos favoritos y finaliza la compra con un solo clic.
                    </p>
                    <div class="btn-box">
                      <a href="#productos" class="btn1">Ver productos</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div> <!-- hero_area -->

  <section class="food_section layout_padding" id="productos">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>Productos disponibles</h2>
        <p>Gestiona tu inventario desde el panel admin y se mostrará aquí automáticamente.</p>
      </div>

      <?php if (!empty($success)): ?>
        <div class="alert alert-success" role="alert"><?= htmlspecialchars($success) ?></div>
      <?php endif; ?>
      <?php if (!empty($error)): ?>
        <div class="alert alert-danger" role="alert"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <div class="row">
        <?php if (count($products) === 0): ?>
          <div class="col-12 text-center">
            <p class="lead">No hay productos creados todavía. Inicia sesión en admin para agregarlos.</p>
          </div>
        <?php endif; ?>
        <?php foreach ($products as $product): ?>
          <div class="col-sm-6 col-lg-4 mb-4">
            <div class="box">
              <div>
                <div class="img-box">
                  <img src="<?= $baseUrl . htmlspecialchars($product['imagen']) ?>" alt="<?= htmlspecialchars($product['nombre']) ?>">
                </div>
                <div class="detail-box">
                  <h5><?= htmlspecialchars($product['nombre']) ?></h5>
                  <p><?= htmlspecialchars(substr($product['descripcion'], 0, 90)) ?><?= strlen($product['descripcion']) > 90 ? '...' : '' ?></p>
                  <div class="options">
                    <h6>$<?= number_format((float)$product['precio'], 2) ?></h6>
                    <?php if ((int)$product['stock'] > 0): ?>
                      <form action="<?= BASE_URL ?>index.php?action=buy" method="POST" class="m-0">
                        <input type="hidden" name="product_id" value="<?= (int)$product['id'] ?>">
                        <button type="submit" class="btn btn-primary">Comprar</button>
                      </form>
                    <?php else: ?>
                      <span class="badge badge-danger">Agotado</span>
                    <?php endif; ?>
                  </div>
                  <small class="text-muted">Stock disponible: <?= (int)$product['stock'] ?></small>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section class="about_section layout_padding" id="nosotros">
    <div class="container  ">
      <div class="row">
        <div class="col-md-6 ">
          <div class="img-box">
            <img src="<?= $baseUrl ?>img/pexels-cottonbro-3298585.jpg" alt="Equipo">
          </div>
        </div>
        <div class="col-md-6">
          <div class="detail-box">
            <div class="heading_container">
              <h2>Sobre la tienda</h2>
            </div>
            <p>
              Esta versión en PHP mantiene el diseño del sitio original y añade un backend con base de datos para que puedas gestionar tu catálogo, registrar ventas y controlar el inventario.
            </p>
            <p>
              Usa el botón de administración para crear, editar o eliminar productos, y ver cómo se publican inmediatamente para tus clientes.
            </p>
            <a href="<?= BASE_URL ?>admin/index.php">Ir al panel</a>
          </div>
        </div>
      </div>
    </div>
  </section>
