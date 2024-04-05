<?php
require_once __DIR__ . '/../../config/db_functions.php';

function getFolderHierarchyFromURI($base = '/src/modules/')
{
    $uri = $_SERVER['REQUEST_URI'];
    $position = strpos($uri, $base);

    if ($position !== false) {
        $path = substr($uri, $position + strlen($base));
        $path = trim($path, '/');
        $folders = explode('/', $path);
        $hierarchy = [];
        $accumulatedPath = '/';

        $hierarchy[] = [
            'nombre' => 'Sistema',
            'link' => '/src/modules/'
        ];

        foreach ($folders as $index => $folder) {
            if ($index === count($folders) - 1 && strpos($folder, '.php') !== false) {
                break;
            }
            $accumulatedPath .= $folder . '/';
            $hierarchy[] = [
                'nombre' => $folder,
                'link' => $accumulatedPath
            ];
        }
        return $hierarchy;
    }

    return [];
}

$hierarchy = getFolderHierarchyFromURI();

?>

<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Inicio</a></li>
    <?php foreach ($hierarchy as $index => $item) : ?>
        <?php
        $nombre_modulo = ucwords($item['nombre']);
        ?>
        <?php if ($index === count($hierarchy) - 1) : ?>
            <li class="breadcrumb-item active"><?= htmlspecialchars($nombre_modulo) ?></li>
        <?php else : ?>
            <li class="breadcrumb-item module_name"><a href="#" class="text-decoration-none"><?= htmlspecialchars($nombre_modulo) ?></a></li>
        <?php endif; ?>
    <?php endforeach; ?>
</ol>

<style>
    .breadcrumb {
        padding: 1rem 1.5rem;
        margin-bottom: 20px;
        background-color: #f5f5f5;
        border-radius: 4px;
    }

    .breadcrumb-item {
        display: inline-block;
    }

    .breadcrumb-item a {
        color: #0275d8;
        text-decoration: none;
    }

    .breadcrumb-item.active span {
        color: #6c757d;
    }

    .breadcrumb-item+.breadcrumb-item::before {
        content: ">";
        padding: 0 5px;
        color: #6c757d;
    }
</style>