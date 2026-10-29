
<?php
require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    die("El ID del cliente no es válido.");
}

$stmt = $conexion->prepare(
    "DELETE FROM clientes WHERE id = ?"
);

$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        $stmt->close();

        header("Location: index.php?estado=eliminado");
        exit;
    }

    $stmt->close();
    die("No se encontro el cliente que deseas eliminar.");
}

$stmt->close();
die("No se pudo eliminar el cliente.");
?>
