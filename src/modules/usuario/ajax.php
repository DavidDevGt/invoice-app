<?php
// ini_set('log_errors', 1);
// ini_set('error_log', './errors.log');
// error_reporting(E_ALL);

require_once "./../../config/db_functions.php";

$accion = $_POST['accion'] ?? $_GET['accion'] ?? '';

switch ($accion) {

    case "mostrar_usuarios":
        $sql = "SELECT
        usuarios.id,
        usuarios.codigo,
        usuarios.usuario,
        usuarios.active,
        roles.nombre AS nombre_rol,
        usuarios.rol_id
        FROM
            usuarios
        LEFT JOIN
            roles ON usuarios.rol_id = roles.id
        ORDER BY usuarios.active DESC";

        $query = dbQuery($sql);
        $json = array();
        while ($row = dbFetchAssoc($query)) {
            $json[] = $row;
        }

        echo json_encode($json);

        break;

    case "usuario_seleccionado":

        $usuario = $_POST['usuario_id'];

        $sql = "SELECT
            usuarios.id,
            usuarios.codigo,
            usuarios.usuario,
            usuarios.rol_id,
            usuarios.active
        FROM
            usuarios
        WHERE
            usuarios.id = " . $usuario;

        $query = dbQuery($sql);
        $json = array();
        while ($row = dbFetchAssoc($query)) {
            $json[] = $row;
        }

        echo json_encode($json);

        break;

    case "mostrar_modulos":

        $sql = "SELECT * FROM modulo WHERE active = 1 ORDER BY orden ASC";

        $query = dbQuery($sql);
        $json = array();
        while ($row = dbFetchAssoc($query)) {
            $json[] = $row;
        }

        echo json_encode($json);

        break;

    case "roles":

        $sql = "SELECT nombre, id FROM roles ORDER BY id ASC";

        $query = dbQuery($sql);
        $json = array();
        while ($row = dbFetchAssoc($query)) {
            $json[] = $row;
        }

        echo json_encode($json);

        break;

    case "mostrar_modulos_hijo":
        $modulo_padre_id = $_POST['modulo_padre_id'];
        $sql = "SELECT * FROM modulo WHERE padre = " . $modulo_padre_id . " ORDER BY orden";

        $query = dbQuery($sql);
        $json = array();
        while ($row = dbFetchAssoc($query)) {
            $json[] = $row;
        }

        echo json_encode($json);

        break;

    case "mostrar_modulos_hijo_usuario":
        $usuario = $_POST['usuario'];
        $sql = "SELECT module_id FROM permisos WHERE usuario_id = " . $usuario;

        $query = dbQuery($sql);
        $json = array();
        while ($row = dbFetchAssoc($query)) {
            $json[] = $row;
        }

        echo json_encode($json);

        break;

    case "crear_usuario":
        // get values 
        $codigo = $_POST['datos']['codigo'];
        $nombres = $_POST['datos']['nombres'];
        $apellidos = $_POST['datos']['apellidos'];
        $usuario = $_POST['datos']['usuario'];
        $password = $_POST['datos']['password'];
        $email = $_POST['datos']['email'];
        $rol = $_POST['datos']['rol'];
        $cpersonal = $_POST['datos']['cpersonal'];
        $cempresa = $_POST['datos']['cempresa'];
        $uuser = $_POST['datos']['uuser'];

        $query = "CALL `tubagua`.`insertUsuario`('$codigo', '$nombres', '$apellidos', '$usuario', '$password', '$email', '$cpersonal', '$cempresa', $rol, $uuser);";
        $result = dbQuery($query);

        if (!$query) {
            $response = array(
                'icon' => 'error',
                'title' => '¡Error!',
                'text' => 'No se guardaron los cambios, error en consulta.'
            );
            echo json_encode($response);
        } else {
            $response = array(
                'icon' => 'success',
                'title' => '¡Exito!',
                'text' => 'Se guardon los cambios.'
            );
            echo json_encode($response);
        }

        break;

    case "guardar_permisos":

        $usuario = $_POST['usuario'];
        $modulo = $_POST['modulo'];
        $modulo_padre = $_POST['padre'];

        // Comprueba si existe un padre
        $sql_padre = "SELECT COUNT(*) AS count FROM tubagua.permiso WHERE permiso.modulo_id = $modulo_padre AND permiso.usuario_id = $usuario";
        $result_padre = dbQuery($sql_padre);
        $row_padre = $result_padre->fetch_assoc();
        $num_rows_padre = $row_padre['count'];

        if ($num_rows_padre > 0) {
            // Verifica si el registro ya existe para el usuario y módulo
            $sql_existencia = "SELECT COUNT(*) AS count FROM tubagua.permiso WHERE permiso.modulo_id = $modulo AND permiso.usuario_id = $usuario";
            $result_existencia = dbQuery($sql_existencia);
            $row_existencia = $result_existencia->fetch_assoc();
            $num_rows = $row_existencia['count'];

            if ($num_rows > 0) {
                // Eliminar el registro existente
                $sqld = "DELETE FROM tubagua.permiso WHERE permiso.modulo_id = $modulo AND permiso.usuario_id = $usuario";
                $result_delete = dbQuery($sqld);
            } else {
                // Insertar nuevo registro
                $sql = "INSERT INTO tubagua.permiso (active, usuario_id, modulo_id, crear, lectura, modificar, eliminar, fecha_alta, user_id)
                            VALUES (1, $usuario, $modulo, 1, 1, 1, 1, NOW(), 1)";
                $result_insert = dbQueryInsert($sql);

                if (!$result_insert) {
                    $response = array(
                        'icon' => 'error',
                        'title' => '¡Error!',
                        'text' => 'No se guardaron los cambios, error en consulta.'
                    );
                    echo json_encode($response);
                    exit;
                }
            }
        } else {
            // Insertar el padre y luego el hijo
            $sql2 = "INSERT INTO tubagua.permiso (active, usuario_id, modulo_id, crear, lectura, modificar, eliminar, fecha_alta, user_id)
                        VALUES (1, $usuario, $modulo_padre, 1, 1, 1, 1, NOW(), 1)";
            $result_insert_padre = dbQueryInsert($sql2);

            $sql = "INSERT INTO tubagua.permiso (active, usuario_id, modulo_id, crear, lectura, modificar, eliminar, fecha_alta, user_id)
                        VALUES (1, $usuario, $modulo, 1, 1, 1, 1, NOW(), 1)";
            $result_insert_hijo = dbQueryInsert($sql);

            if (!$result_insert_hijo) {
                $response = array(
                    'icon' => 'error',
                    'title' => '¡Error!',
                    'text' => 'No se guardaron los cambios, error en consulta.'
                );
                echo json_encode($response);
                exit;
            }
        }

        $response = array(
            'icon' => 'success',
            'title' => '¡Éxito!',
            'text' => 'Se guardaron los cambios.'
        );
        echo json_encode($response);



        break;

    case "editar_usuario":
        $id = $_POST['formData']['usuario_id'];
        $nombres = $_POST['formData']['nombres'];
        $apellidos = $_POST['formData']['apellidos'];
        $usuario = $_POST['formData']['usuario'];
        $correo = $_POST['formData']['correo'];
        $celular_e = $_POST['formData']['celular_e'];
        $celular_p = $_POST['formData']['celular_p'];
        $rol = $_POST['formData']['rol'];
        $estado = $_POST['formData']['estado'];


        $sql = "UPDATE tubagua.usuario
                    SET 
                    usuario.nombres = '" . $nombres . "',
                    usuario.apellidos = '" . $apellidos . "',
                    usuario.usuario = '" . $usuario . "',
                    usuario.email = '" . $correo . "',
                    usuario.celular_personal = '" . $celular_p . "',
                    usuario.celular_empresa = '" . $celular_e . "',
                    usuario.rol_id = " . $rol . ",
                    usuario.active = " . $estado . "
                    WHERE usuario.id = " . $id;

        $result = dbQuery($sql);

        if (!$result) {
            $response = array(
                'icon' => 'error',
                'title' => '¡Error!',
                'text' => 'No se guardaron los cambios, error en consulta.'
            );
            echo json_encode($response);
        } else {
            $response = array(
                'icon' => 'success',
                'title' => '¡Exito!',
                'text' => 'Se guardon los cambios.'
            );
            echo json_encode($response);
        }
}
