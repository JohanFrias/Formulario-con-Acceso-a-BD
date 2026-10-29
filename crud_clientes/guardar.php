
<?php
require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

$id = (int) ($_POST["id"] ?? 0);
$nombre = trim($_POST["nombre"] ?? "");
$correo = trim($_POST["correo"] ?? "");
$telefono = trim($_POST["telefono"] ?? "");

if (
    $nombre === "" ||
    !filter_var($correo, FILTER_VALIDATE_EMAIL) ||
    $telefono === "" ||
    strlen($nombre) > 100 ||
    strlen($correo) > 150 ||
    strlen($telefono) > 20
) {
    die("Verifica los datos ingresados.");
}

if ($id > 0) {

    // Modificar un cliente existente
    $stmt = $conexion->prepare(
        "UPDATE clientes
         SET nombre = ?, correo = ?, telefono = ?
         WHERE id = ?"
    );

    $stmt->bind_param(
        "sssi",
        $nombre,
        $correo,
        $telefono,
        $id
    );

    $estado = "actualizado";
} else {

    // Insertar un cliente nuevo
    $stmt = $conexion->prepare(
        "INSERT INTO clientes (nombre, correo, telefono)
         VALUES (?, ?, ?)"
    );

    $stmt->bind_param(
        "sss",
        $nombre,
        $correo,
        $telefono
    );

    $estado = "creado";
}

if ($stmt->execute()) {
    if ($id > 0 && $stmt->affected_rows === 0) {

        // Puede significar que no existe el ID o que ya existe
        $stmt->close();

        if ($id > 0) {
            $verificar = $conexion->prepare(
                "SELECT id FROM clientes WHERE id = ?"
            );
            $verificar->bind_param("i", $id);
            $verificar->execute();
            $existe = $verificar->get_result()->num_rows > 0;
            $verificar->close();

            if (!$existe) {
                die("El cliente no existe.");
            }
        }
    }

    $stmt->close();

    header("Location: index.php?estado=" . $estado);
    exit;
}

$stmt->close();
die("No se pudo guardar el cliente.");
?>
