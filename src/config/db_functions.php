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


// Limpiar data
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
