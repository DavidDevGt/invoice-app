<?php
require_once './vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

ini_set('log_errors', 1);
ini_set('error_log', './errors.log');
error_reporting(E_ALL);

include './src/config/db_functions.php';

$key = "]ymHeM;}]\yG;-6TKA@p.:i8SHrlR-:PTXmRFfPPb";
$time = time();

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
            $payload = [
                'iat' => $time,
                'exp' => $time + (4 * 60 * 60),  // Token expira en 4 horas
                'sub' => $user['id'],
                'data' => [
                    'usuario_id' => $user['id'],
                    'usuario' => $user['usuario'],
                    'rol_id' => $user['rol_id']
                ]
            ];

            $jwt = JWT::encode($payload, $key, 'HS256');
            echo json_encode(['success' => true, 'token' => $jwt]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Credenciales incorrectas. Por favor, intentar de nuevo.']);
        }
        $stmt->close();
        $conn->close();
        exit;
    }
}
