<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isAuthenticated() {
    return isset($_SESSION['usuario_id']) && isset($_SESSION['usuario']) && isset($_SESSION['rol_id']);
}

// if (!isAuthenticated()) {
//     echo "No tienes permiso para ver esta página. Por favor, inicia sesión.";
//     exit;
// }

if (!isAuthenticated()) {
    echo "No tienes permiso para ver esta página. Por favor, inicia sesión.";
    echo "<br>";
    echo "Detalles de sesión:";
    echo "<br>";
    echo "ID de usuario: " . ($_SESSION['usuario_id'] ?? 'No definido');
    echo "<br>";
    echo "Usuario: " . ($_SESSION['usuario'] ?? 'No definido');
    echo "<br>";
    echo "ID de rol: " . ($_SESSION['rol_id'] ?? 'No definido');
    
    echo "<div class='p-4 m-4 bg-white rounded'>
    <?php phpinfo(); ?>
    </div>";
    exit;
}