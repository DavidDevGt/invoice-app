<?php
// ini_set('log_errors', 1);
// ini_set('error_log', './errors.log');
// error_reporting(E_ALL);

require_once "./../../config/db.php";

$accion = $_POST['accion'] ?? $_GET['accion'] ?? '';

switch ($accion) {
    case 'crear':
        break;
    case 'actualizar':
        break;
    case 'eliminar':
        break;
    case 'leer':
        break;
    default:
        echo json_encode(['error' => 'Acción no reconocida']);
        break;
}

