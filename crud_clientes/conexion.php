
<?php
$conexion = new mysqli(
    "127.0.0.1",
    "admin",
    "admin1234*",
    "crud_clientes",
    3306
);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$conexion->set_charset("utf8mb4");
?>
