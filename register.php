<?php
include './src/config/db.php';

// Comprobación si se ejecuta desde CLI
if (php_sapi_name() == "cli") {
    // Modo CLI
    $usuario = 'admin1';
    $password = 'admin1';
    $codigo = 'ADMIN';
} else {
    // Modo Web
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $usuario = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $codigo = $_POST['codigo'] ?? '';
    }
}

if (isset($usuario) && $usuario !== '' && isset($password) && $password !== '') {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $conn = getDbConnection();
    $stmt = $conn->prepare('INSERT INTO usuarios (usuario, password, active) VALUES (?, ?, TRUE)');
    $stmt->bind_param('ss', $usuario, $hashedPassword);

    if ($stmt->execute()) {
        echo "Usuario registrado\n";
    } else {
        echo "Error al registrar\n";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Falta usuario o password\n";
}
