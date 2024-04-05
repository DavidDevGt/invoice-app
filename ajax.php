<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include './src/config/db.php';

if (isset($_SESSION['usuario_id'])) {
    header('Location: modules/dashboard.php');
    exit;
}

if (isset($_POST['fnc']) && $_POST['fnc'] == "login") {
    $usuario = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($usuario !== '' && $password !== '') {
        $conn = getDbConnection();

        $stmt = $conn->prepare("SELECT id, usuario, rol_id FROM usuarios WHERE usuario = ? AND active = 1");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {

            $_SESSION['usuario_id'] = $user['id'];
            $_SESSION['usuario'] = $user['usuario'];
            $_SESSION['rol_id'] = $user['rol_id'];
        
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Credenciales incorrectas. Por favor, intentar de nuevo.']);
        }
        $stmt->close();
        $conn->close();
        exit;
    }
}
