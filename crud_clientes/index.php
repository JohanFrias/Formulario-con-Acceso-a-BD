
<?php
require_once "conexion.php";

$id = "";
$nombre = "";
$correo = "";
$telefono = "";

// Cargar un cliente para editarlo
if (isset($_GET["editar"])) {
    $id = (int) $_GET["editar"];

    $stmt = $conexion->prepare(
        "SELECT * FROM clientes WHERE id = ?"
    );
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $resultadoEditar = $stmt->get_result();

    if ($cliente = $resultadoEditar->fetch_assoc()) {
        $nombre = $cliente["nombre"];
        $correo = $cliente["correo"];
        $telefono = $cliente["telefono"];
    } else {
        $id = "";
    }

    $stmt->close();
}

// Consultar todos los clientes
$resultado = $conexion->query(
    "SELECT * FROM clientes ORDER BY id DESC"
);

// Evitar interpretar los datos como HTML
function escapar($valor) {
    return htmlspecialchars(
        (string) $valor,
        ENT_QUOTES,
        "UTF-8"
    );
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de clientes</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<div class="contenedor">
    <h1>Gestión de clientes</h1>
    <p class="subtitulo">Sistema de registro de clientes</p>

    <section class="formulario">
        <h2>
            <?= $id !== "" ? "Modificar cliente" : "Registrar cliente" ?>
        </h2>

        <form action="guardar.php" method="POST">
            <input
                type="hidden"
                name="id"
                value="<?= escapar($id) ?>"
            >

            <label for="nombre">Nombre completo</label>
            <input
                type="text"
                id="nombre"
                name="nombre"
                maxlength="100"
                value="<?= escapar($nombre) ?>"
                required
            >

            <label for="correo">Correo electrónico</label>
            <input
                type="email"
                id="correo"
                name="correo"
                maxlength="150"
                value="<?= escapar($correo) ?>"
                required
            >

            <label for="telefono">Telefono</label>
            <input
                type="tel"
                id="telefono"
                name="telefono"
                maxlength="20"
                value="<?= escapar($telefono) ?>"
                required
            >

            <button type="submit">
                <?= $id !== "" ? "Guardar cambios" : "Registrar cliente" ?>
            </button>

            <?php if ($id !== ""): ?>
                <a class="cancelar" href="index.php">
                    Cancelar edición
                </a>
            <?php endif; ?>
        </form>
    </section>

    <section class="tabla">
        <h2>Clientes registrados</h2>

        <?php if (isset($_GET["estado"])): ?>
            <p class="mensaje">
                <?php
                $mensajes = [
                    "creado" => "Cliente registrado correctamente.",
                    "actualizado" => "Cliente modificado correctamente.",
                    "eliminado" => "Cliente eliminado correctamente."
                ];

                echo escapar(
                    $mensajes[$_GET["estado"]] ?? "Operación completada."
                );
                ?>
            </p>
        <?php endif; ?>

        <div class="tabla-scroll">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if ($resultado->num_rows > 0): ?>
                        <?php while ($fila = $resultado->fetch_assoc()): ?>
                            <tr>
                                <td><?= escapar($fila["id"]) ?></td>
                                <td><?= escapar($fila["nombre"]) ?></td>
                                <td><?= escapar($fila["correo"]) ?></td>
                                <td><?= escapar($fila["telefono"]) ?></td>

                                <td class="acciones">
                                    <a
                                        class="editar"
                                        href="index.php?editar=<?= (int) $fila["id"] ?>"
                                    >
                                        Editar
                                    </a>

                                    <form
                                        action="eliminar.php"
                                        method="POST"
                                        onsubmit="return confirm('¿Seguro que deseas eliminar este cliente?')"
                                    >
                                        <input
                                            type="hidden"
                                            name="id"
                                            value="<?= (int) $fila["id"] ?>"
                                        >

                                        <button
                                            type="submit"
                                            class="eliminar"
                                        >
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">
                                No hay clientes registrados.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>

</body>
</html>
