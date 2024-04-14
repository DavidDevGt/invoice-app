<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isAuthenticated() {
    return isset($_SESSION['usuario_id']) && isset($_SESSION['usuario']) && isset($_SESSION['rol_id']);
}

if (!isAuthenticated()) {
    echo "No tienes permiso para ver esta página. Por favor, inicia sesión.";
    exit;
}
