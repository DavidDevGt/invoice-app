<?php
// db.php
$host = 'localhost';
$dbUser = 'root';
$dbPassword = '';
$dbName = 'sistema_facturacion';

$conn = new mysqli($host, $dbUser, $dbPassword, $dbName);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

function getDbConnection() {
    global $conn;
    return $conn;
}
