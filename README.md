# Tienda Online en PHP

Esta versión convierte el sitio estático en una aplicación PHP con patrón MVC, MySQL y panel administrativo.

## Estructura
- `public/`: punto de entrada de la aplicación y assets (css, js, img, fonts, uploads).
  - `index.php`: tienda para clientes.
  - `admin/`: panel de administración con autenticación.
- `controllers/`, `models/`, `views/`: capas MVC con plantillas reutilizables.
- `config.php`: conexión MySQL y helpers.
- `database.sql`: script de creación de base de datos y usuario admin inicial.

## Instalación
1. Crea la base de datos e importa el esquema:
   ```sql
   SOURCE database.sql;
   ```
2. Configura las credenciales en `config.php` (`DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASSWORD`). El `BASE_URL` se calcula automáticamente según la carpeta en la que se ejecute (`/public/` si usas la raíz del repo, `/` si apuntas el servidor a `public/`).
3. Asegúrate de que `public/uploads/` tenga permisos de escritura para subir imágenes.
4. Inicia el servidor PHP apuntando a `public/` como raíz web:
   ```bash
   php -S localhost:8000 -t public
   ```
5. Accede a:
   - Tienda: `http://localhost:8000`
   - Panel admin: `http://localhost:8000/admin/` (usuario `admin`, contraseña `admin123`).

## Flujo principal
- El admin ingresa al panel, crea productos con sus imágenes y gestiona stock.
- La tienda muestra los productos creados; los clientes agregan ítems al carrito, ajustan cantidades y finalizan la compra simulada.
- El checkout registra ventas, descuenta stock y bloquea compras sin inventario disponible.
