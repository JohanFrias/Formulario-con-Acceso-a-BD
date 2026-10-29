# CRUD de Clientes

Aplicación web sencilla para administrar clientes mediante operaciones CRUD: crear, consultar, modificar y eliminar registros.

## Tecnologías utilizadas

- PHP
- MySQL
- HTML y CSS
- Apache (XAMPP)

## Requisitos
- Las apps que utilice fueron:
- XAMPP o un entorno que tenga Apache y PHP.
- MySQL Server.
- Navegador web.

> Se puede utilizar el servidor MySQL si esta instalado por separado. No es necesario iniciar el módulo MySQL de XAMPP si ya se utilizamos otro servidor MySQL o en cambio tambien
 se puede hacer solo con XAMPP ya que tiene dicho modulo.

## Instalación

1. Clona o descarga este repositorio.
2. Coloca la carpeta `crud_clientes` dentro de la carpeta `htdocs` de XAMPP. Por ejemplo:

   `C:\Xampp\htdocs\crud_clientes`

3. Inicia Apache desde el panel de control de XAMPP.
4. Abre MySQL Workbench y conéctate a tu servidor MySQL.
5. Ejecuta el contenido del archivo `database.sql` para crear la base de datos y la tabla.
6. Configura las credenciales de conexión en `conexion.php` para que coincidan con tu servidor MySQL.
7. Abre el proyecto en el navegador:

   `http://localhost/crud_clientes/`

## Configuración de la conexión

El archivo `conexion.php` contiene los datos necesarios para conectarse a MySQL: servidor, usuario, contraseña, base de datos y puerto.


## Base de datos

La base de datos se llama `crud_clientes` y contiene la tabla `clientes`, con los siguientes campos:

| Campo | Descripción |
|---|---|
| `id` | Identificador único autoincremental |
| `nombre` | Nombre del cliente |
| `correo` | Correo electrónico del cliente |
| `telefono` | Teléfono del cliente |

