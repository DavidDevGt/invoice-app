<?php
// ini_set('log_errors', 1);
// ini_set('error_log', './errors.log');
// error_reporting(E_ALL);

require_once "./../../config/db_functions.php";

$accion = $_POST['accion'] ?? $_GET['accion'] ?? '';

switch ($accion) {
    case 'crear':
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
        break;
    case 'actualizar':
        break;
    case 'eliminar':
        break;
    case 'leer':
        $sql = 'SELECT * FROM modulos WHERE active = 1 ORDER BY orden';
        $result = dbQuery($sql);

        $modulos = [];

        if (dbNumRows($result) > 0) {
            while ($modulo = dbFetchAssoc($result)) {
                $modulos[] = $modulo;
            }
        }

        // JSON
        echo json_encode($modulos);
        break;
    default:
        echo json_encode(['error' => 'Acción no reconocida']);
        break;
}
