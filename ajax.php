<?php

session_start();
include './config/db.php'; // Asegúrate de que este archivo contenga la función getDbConnection()

if (isset($_SESSION['usuario_id'])) {
    header('Location: modules/dashboard.php'); // Redirige al usuario a la página de inicio si ya inició sesión
    exit;
}

if (isset($_POST['fnc']) && $_POST['fnc'] == "login") {
    $usuario = $_POST['usuario'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($usuario !== '' && $password !== '') {
        $conn = getDbConnection();
        // Modifica la consulta para obtener el hash de la contraseña
        $stmt = $conn->prepare("SELECT id, nombre, email, password, rol_id FROM usuarios WHERE usuario = ? AND active = TRUE");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            // La contraseña coincide
            $_SESSION['usuario_id'] = $user['id'];
            $_SESSION['nombre'] = $user['nombre'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['rol_id'] = $user['rol_id'];
        
            echo json_encode(['success' => true]);
        } else {
            // Usuario no encontrado o contraseña incorrecta
            echo json_encode(['success' => false]);
        }
        $stmt->close();
        $conn->close();
        exit;
    }
}
