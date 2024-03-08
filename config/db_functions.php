<?php
include 'db.php';

// Ejecuta una consulta y devuelve el resultado
function dbQuery($sql) {
    $conn = getDbConnection();
    $result = $conn->query($sql);
    $conn->close();
    return $result;
}

// Inserta datos y devuelve el ID del último registro insertado
function dbQueryInsert($sql) {
    $conn = getDbConnection();
    $conn->query($sql);
    $lastId = $conn->insert_id;
    $conn->close();
    return $lastId;
}

// Obtiene todos los registros como un array de arrays
function dbFetchAll($sql) {
    $conn = getDbConnection();
    $result = $conn->query($sql);
    $fetchAll = $result->fetch_all(MYSQLI_ASSOC);
    $conn->close();
    return $fetchAll;
}

// Obtiene un solo registro como un array asociativo
function dbFetchAssoc($sql) {
    $conn = getDbConnection();
    $result = $conn->query($sql);
    $fetchAssoc = $result->fetch_assoc();
    $conn->close();
    return $fetchAssoc;
}

// Devuelve el número de filas afectadas por la última consulta
function dbNumRows($sql) {
    $conn = getDbConnection();
    $result = $conn->query($sql);
    $numRows = $result->num_rows;
    $conn->close();
    return $numRows;
}