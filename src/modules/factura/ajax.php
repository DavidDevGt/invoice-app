<?php
require_once "./../../config/db_functions.php";

$accion = $_POST['accion'] ?? $_GET['accion'] ?? '';

// $id = $_POST['id'] ??'';

$sql = "SELECT * FROM usuarios WHERE active = 1 AND id = $id";

$result = dbQuery($sql);

$usuarios = [];

while ($usuario = dbFetchAssoc($result)) {
    $usuarios[] = $usuario;
}

echo json_encode($usuarios);
