<?php
// Activar registro de errores
// ini_set('log_errors', 1);
// ini_set('error_log', './errors.log');
// error_reporting(E_ALL);

require_once "./../../config/db_functions.php";

$accion = $_POST['accion'] ?? $_GET['accion'] ?? '';

switch ($accion) {
    case 'create':
        try {
            $nombre = sanitizeInput($_POST['nombre']);
            $descripcion = sanitizeInput($_POST['descripcion']);
            $active = ($_POST['active'] === 'true') ? 1 : 0;
            $sql = "INSERT INTO roles (nombre, descripcion, active) VALUES (?, ?, ?)";
            $lastId = dbQueryPreparedInsert($sql, "ssi", [$nombre, $descripcion, $active]);
            echo json_encode(['success' => true, 'lastId' => $lastId]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error al crear el rol: ' . $e->getMessage()]);
        }
        break;

    case 'read':
        try {
            $sql = "SELECT * FROM roles WHERE active = 1 ORDER BY nombre ASC";
            $result = dbQuery($sql);
            $roles = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $roles[] = $row;
            }
            echo json_encode($roles);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error al leer los roles: ' . $e->getMessage()]);
        }
        break;

    case 'update':
        try {
            $id = sanitizeInput($_POST['id']);
            $nombre = sanitizeInput($_POST['nombre']);
            $descripcion = sanitizeInput($_POST['descripcion']);
            $active = ($_POST['active'] === 'true') ? 1 : 0;
            $sql = "UPDATE roles SET nombre = '{$nombre}', descripcion = '{$descripcion}', active = {$active} WHERE id = {$id}";
            dbQuery($sql);
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error al actualizar el rol: ' . $e->getMessage()]);
        }
        break;

    case 'delete':
        try {
            $id = sanitizeInput($_POST['id']);
            $sql = "UPDATE roles SET active = 0 WHERE id = {$id}";
            dbQuery($sql);
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error al eliminar el rol: ' . $e->getMessage()]);
        }
        break;

    default:
        echo json_encode(['error' => 'Acción no reconocida']);
        break;
}
