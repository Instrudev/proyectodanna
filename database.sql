CREATE DATABASE IF NOT EXISTS tienda_online CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE tienda_online;

CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT NOT NULL,
    precio DECIMAL(10,2) NOT NULL DEFAULT 0,
    stock INT NOT NULL DEFAULT 0,
    imagen VARCHAR(255) NOT NULL,
    fecha_creacion DATETIME NOT NULL,
    fecha_actualizacion DATETIME NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS ventas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    fecha_venta DATETIME NOT NULL,
    CONSTRAINT fk_ventas_producto FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS usuarios_admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

INSERT INTO usuarios_admin (usuario, password_hash)
VALUES ('admin', '$2y$12$XDhawdzLh.tuJAvtsWK8zepWT4KzWyn7EoTUpBxXK0QmrxKWbomK6')
ON DUPLICATE KEY UPDATE usuario = usuario;
