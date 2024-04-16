<?php
require_once './../../../vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$key = "]ymHeM;}]\yG;-6TKA@p.:i8SHrlR-:PTXmRFfPPb";

$headers = getallheaders();
$token = $headers['Authorization'] ?? '';

try {
    $decoded = JWT::decode($token, new Key($key, 'HS256'));
    // Aquí puedes agregar más lógica para verificar los roles o permisos específicos
} catch (Exception $e) {
    echo "No tienes permiso para ver esta página. Por favor, inicia sesión.";
    exit;
}
