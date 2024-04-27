<?php
// ini_set('log_errors', 1);
// ini_set('error_log', './errors.log');
// error_reporting(E_ALL);

require './src/config/db_functions.php';
require_once './vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$key = "]ymHeM;}]\yG;-6TKA@p.:i8SHrlR-:PTXmRFfPPb";
$time = time();

function main()
{
    if (!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['fnc']) || $_POST['fnc'] !== "login") {
        echo json_encode(['success' => false, 'error' => 'Petición incorrecta.']);
        return;
    }

    $usuario = sanitizeInput($_POST['username']);
    $password = sanitizeInput($_POST['password']);
    if (empty($usuario) || empty($password)) {
        echo json_encode(['success' => false, 'error' => 'Los campos no pueden estar vacíos.']);
        return;
    }

    loginUser($usuario, $password);
}

function loginUser($usuario, $password)
{
    $conn = getDbConnection();
    $stmt = $conn->prepare("SELECT id, password, usuario, rol_id FROM usuarios WHERE usuario = ? AND active = 1");
    if (!$stmt) {
        echo json_encode(['success' => false, 'error' => 'Error en la base de datos.']);
        return;
    }

    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user || !password_verify($password, $user['password'])) {
        echo json_encode(['success' => false, 'error' => 'Credenciales incorrectas.']);
        $stmt->close();
        return;
    }

    $jwt = createJwt($user);
    setcookie("user_id", $user['id'], time() + (1 * 60 * 60), "/", "", true, true);
    echo json_encode(['success' => true, 'token' => $jwt, 'username' => $user['usuario']]);

    $stmt->close();
    $conn->close();
}

function createJwt($user)
{
    global $key, $time;
    $payload = [
        'iat' => $time,
        'exp' => $time + (1 * 60 * 60),
        'sub' => $user['id'],
        'data' => ['usuario_id' => $user['id'], 'usuario' => $user['usuario'], 'rol_id' => $user['rol_id']]
    ];
    return JWT::encode($payload, $key, 'HS256');
}

main();