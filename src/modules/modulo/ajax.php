<?php
require_once "./../../config/db_functions.php";

$accion = $_POST['accion'] ?? $_GET['accion'] ?? '';

switch ($accion) {
    case 'crear':
        crearModulo();
        break;
    case 'actualizar':
        actualizarModulo();
        break;
    case 'eliminar':
        eliminarModulo();
        break;
    case 'leer':
        leerModulos();
        break;
    case 'modulo_seleccionado':
        leerModuloPorId();
        break;

    default:
        echo json_encode(['error' => 'Acción no reconocida']);
        break;
}

function crearModulo()
{
    $nombre_modulo = sanitizeInput($_POST['nombre_modulo']);
    $orden = sanitizeInput($_POST['orden']);
    $ruta = sanitizeInput($_POST['ruta']);

    $sql = "INSERT INTO modulos (nombre, orden, ruta) VALUES ('$nombre_modulo', '$orden', '$ruta')";

    $result = dbQuery($sql);

    if ($result) {
        echo json_encode(['success' => 'Módulo creado exitosamente']);
    } else {
        echo json_encode(['error' => 'Error al crear el módulo']);
    }
}

function actualizarModulo()
{
    $id = sanitizeInput($_POST['id']);
    $nombre_modulo = sanitizeInput($_POST['nombre_modulo']);
    $orden = sanitizeInput($_POST['orden']);
    $ruta = sanitizeInput($_POST['ruta']);

    $sql = "UPDATE modulos SET nombre = '$nombre_modulo', orden = '$orden', ruta = '$ruta' WHERE id = $id";

    $result = dbQuery($sql);

    if ($result) {
        echo json_encode(['success' => 'Módulo actualizado exitosamente']);
    } else {
        echo json_encode(['error' => 'Error al actualizar el módulo']);
    }
}

function eliminarModulo()
{
    $id = sanitizeInput($_POST['id']);

    $sql = "UPDATE modulos SET active = 0 WHERE id = $id";

    $result = dbQuery($sql);

    if ($result) {
        echo json_encode(['success' => 'Módulo eliminado exitosamente']);
    } else {
        echo json_encode(['error' => 'Error al eliminar el módulo']);
    }
}

function leerModulos()
{
    $sql = 'SELECT * FROM modulos ORDER BY orden';
    $result = dbQuery($sql);

    $modulos = [];

    if (dbNumRows($result) > 0) {
        while ($modulo = dbFetchAssoc($result)) {
            $modulos[] = $modulo;
        }
    }

    echo json_encode($modulos);
}

function leerModuloPorId()
{
    $id = sanitizeInput($_POST['id']);
    $sql = "SELECT * FROM modulos WHERE id = $id";
    $result = dbQuery($sql);

    if ($modulo = dbFetchAssoc($result)) {
        echo json_encode($modulo);
    } else {
        echo json_encode(['error' => 'Módulo no encontrado']);
    }
}
