<?php
session_start();

// Eliminar todas las variables de sesión.
$_SESSION = array();

// Si se desea destruir la sesión completamente, borrar también la cookie de sesión.
// Esto destruirá la sesión, y no la información de la sesión.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finalmente, destruir la sesión.
session_destroy();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cierre de Sesión</title>
<!-- Enlace al archivo CSS de Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="alert alert-danger mt-5" role="alert">
        ¡La sesión se ha cerrado exitosamente!
    </div>
</div>
</body>
</html>
