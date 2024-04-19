<?php
require_once './../../../vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

header('Content-Type: application/json');

$key = "]ymHeM;}]\yG;-6TKA@p.:i8SHrlR-:PTXmRFfPPb";
$headers = getallheaders();
$token = $headers['Authorization'] ?? '';

if (preg_match('/Bearer\s(\S+)/', $token, $matches)) {
    $token = $matches[1];  // Extrae el token del encabezado
}

try {
    $decoded = JWT::decode($token, new Key($key, 'HS256'));
    echo json_encode(['status' => 'success', 'message' => 'Token verified']);
    exit;
} catch (Exception $e) {
    http_response_code(401); // No autorizado
    echo json_encode(['status' => 'error', 'message' => 'Invalid token']);
    exit;
}
