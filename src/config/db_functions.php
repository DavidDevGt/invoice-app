<?php
include 'db.php';

// Ejecuta una consulta y devuelve el resultado
function dbQuery($sql)
{
    $conn = getDbConnection();
    $result = $conn->query($sql);
    $conn->close();
    return $result;
}

// Inserta datos y devuelve el ID del último registro insertado
function dbQueryInsert($sql)
{
    $conn = getDbConnection();
    $conn->query($sql);
    $lastId = $conn->insert_id;
    $conn->close();
    return $lastId;
}

function dbFetchAssoc($result)
{
    $return = mysqli_fetch_assoc($result);
    return $return;
}

function dbNumRows($result)
{
    return mysqli_num_rows($result);
}

function dbQueryPreparedSelect($sql, $types = "", $params = [])
{
    $conn = getDbConnection();
    $stmt = $conn->prepare($sql);
    if ($types && $params) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}

function dbQueryPreparedInsert($sql, $types, $params)
{
    $conn = getDbConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $lastId = $stmt->insert_id;
    $stmt->close();
    return $lastId;
}

function getModulosPadre() {
    $sql = "SELECT * FROM modulos WHERE padre_id IS NULL AND active = 1 ORDER BY orden ASC";
    return dbQueryPreparedSelect($sql);
}

function getModulosHijos($padreId) {
    $sql = "SELECT * FROM modulos WHERE padre_id = ? AND active = 1 ORDER BY orden ASC";
    return dbQueryPreparedSelect($sql, 'i', [$padreId]);
}



// Limpiar datos
function sanitizeInput($data)
{
    if (is_array($data)) {
        foreach ($data as $key => $value) {
            $data[$key] = sanitizeInput($value);
        }
        return $data;
    } else {
        $data = trim($data);
        $data = strip_tags($data);
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        return $data;
    }
}

// Notifications no leidas por user
function getUnreadNotifications($userId) {
    $sql = "SELECT tipo, mensaje FROM notificaciones WHERE usuario_id = $userId AND leido = FALSE";
    return dbQuery($sql);
}