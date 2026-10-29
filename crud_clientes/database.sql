-- Base de datos para el proyecto CRUD de clientes
-- Ejecutar este script desde MySQL Workbench o desde un cliente MySQL.

CREATE DATABASE IF NOT EXISTS crud_clientes
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE crud_clientes;

CREATE TABLE IF NOT EXISTS clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(150) NOT NULL,
    telefono VARCHAR(20) NOT NULL
);
