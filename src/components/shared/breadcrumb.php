<?php
require_once __DIR__ . '/../../../config/db_functions.php';

function getFolderHierarchy($path = '') {
    $folders = explode('/', trim($path, '/'));
    $hierarchy = [];
    $accumulatedPath = '';
    foreach ($folders as $folder) {
        $accumulatedPath .= $folder . '/';
        $hierarchy[] = [
            'nombre' => $folder,
            'link' => '/' . trim($accumulatedPath, '/')
        ];
    }
    return $hierarchy;
}

// Asumimos que `path` es un parámetro GET que representa la ruta actual dentro de la estructura de carpetas de la aplicación
$currentPath = $_GET['path'] ?? '';

// Obtener la jerarquía de carpetas basada en la ruta actual
$hierarchy = getFolderHierarchy($currentPath);
?>

<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
    <?php foreach ($hierarchy as $item): ?>
        <li class="breadcrumb-item">
            <a href="<?= htmlspecialchars($item['link']) ?>"><?= htmlspecialchars($item['nombre']) ?></a>
        </li>
    <?php endforeach; ?>
</ol>
