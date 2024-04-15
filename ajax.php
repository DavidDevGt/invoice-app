<?php
ini_set('log_errors', 1);
ini_set('error_log', './errors.log');
error_reporting(E_ALL);

session_start();

// Configura el tiempo de vida de la sesión
$tiempo_vida_sesion = 4 * 60 * 60; // 4 horas
session_set_cookie_params($tiempo_vida_sesion);

include './src/config/db_functions.php';

session_regenerate_id(true);

if (isset($_SESSION['usuario_id'])) {
    header('Location: src/modules/dashboard/dashboard.php');
    exit;
}

if (isset($_POST['fnc']) && $_POST['fnc'] == "login") {
    $usuario = sanitizeInput($_POST['username']);
    $password = sanitizeInput($_POST['password']);

    if ($usuario !== '' && $password !== '') {
        $conn = getDbConnection();

        $stmt = $conn->prepare("SELECT id, password, usuario, rol_id FROM usuarios WHERE usuario = ? AND active = 1");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {

            $_SESSION['usuario_id'] = $user['id'];
            $_SESSION['usuario'] = htmlspecialchars($user['usuario'], ENT_QUOTES, 'UTF-8');
            $_SESSION['rol_id'] = $user['rol_id'];

            error_log("Inicio de sesión exitoso para usuario: " . $_SESSION['usuario']);
            error_log("Rol ID: " . $_SESSION['rol_id']);
            error_log("Usuario ID: " . $_SESSION['usuario_id']);

            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Credenciales incorrectas. Por favor, intentar de nuevo.']);
        }
        $stmt->close();
        $conn->close();
        exit;
    }
}
