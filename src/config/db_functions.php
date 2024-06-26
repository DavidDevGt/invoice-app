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

function dbQueryUpdate($sql)
{
    $conn = getDbConnection();
    if (!$conn) {
        throw new Exception("No se pudo conectar a la base de datos.");
    }

    if ($conn->connect_error) {
        throw new Exception("Fallo de conexión: " . $conn->connect_error);
    }

    $result = $conn->query($sql);
    if ($result === false) {
        // Captura el error específico de SQL antes de cerrar la conexión.
        $error = $conn->error;
        $conn->close();
        throw new Exception("Error SQL: " . $error);
    }

    $conn->close();
    return $result;
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

// Navbar functions
function tienePermisoLectura($usuarioId, $moduloId)
{
    $conn = getDbConnection();

    $sql = "SELECT 1 FROM permisos WHERE usuario_id = $usuarioId AND module_id = $moduloId AND lectura = 1 AND active = 1 LIMIT 1";

    $result = $conn->query($sql);

    if ($result) {
        $exists = mysqli_num_rows($result) > 0;
        mysqli_free_result($result);  // Liberar el resultado
        return $exists;
    } else {
        error_log('Error en consulta de permisos: ' . $conn->error);
        return false;
    }
}

function getBaseURL()
{
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $uriParts = explode('/', $_SERVER['REQUEST_URI']);
    $dirPath = '';
    foreach ($uriParts as $part) {
        if ($part == 'src')
            break;
        $dirPath .= $part . '/';
    }
    $baseURL = $protocol . '://' . $host . '' . $dirPath . 'src/';
    return rtrim($baseURL, '/') . '/';
}

function getModulosPadre()
{
    $sql = "SELECT * FROM modulos WHERE padre_id IS NULL AND active = 1 ORDER BY orden ASC";
    return dbQueryPreparedSelect($sql);
}

function getModulosHijos($padreId)
{
    $sql = "SELECT * FROM modulos WHERE padre_id = ? AND active = 1 ORDER BY orden ASC";
    return dbQueryPreparedSelect($sql, 'i', [$padreId]);
}

// Notifications no leidas por user
function getUnreadNotifications($userId)
{
    $sql = "SELECT tipo, mensaje FROM notificaciones WHERE usuario_id = $userId AND leido = FALSE";
    return dbQuery($sql);
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
