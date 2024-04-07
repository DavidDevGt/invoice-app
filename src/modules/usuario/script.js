'use strict';

$(document).ready(function () {
    $('#crearModulo').click(function () {
        mostrarModalCrearUsuario();
    });
    mostrarUsuarios();
});

// Mostrar usuarios
function mostrarUsuarios() {
    $.ajax({
        type: "POST",
        url: "ajax.php",
        data: { accion: "mostrar_usuarios" },
        success: function (response) {
            let usuarios = JSON.parse(response);
            let filasUsuarios = '';
            usuarios.forEach(usuario => {
                filasUsuarios += `
                    <tr>
                        <td>${usuario.id}</td>
                        <td>${usuario.codigo}</td>
                        <td>${usuario.usuario}</td>
                        <td>${usuario.nombre_rol}</td>
                        <td>${usuario.active == 1 ? 'Activo' : 'Inactivo'}</td>
                        <td>
                            <button type="button" onclick="mostrarModalPermisos('${usuario.usuario}', ${usuario.id})" class="btn btn-sm btn-secondary">Gestionar Permisos</button>
                            <button type="button" onclick="mostrarModalEditarUsuario(${usuario.id})" class="btn btn-sm btn-success">Editar</button>
                        </td>
                    </tr>
                `;
            });
            $('#tablebody').html(filasUsuarios);
        }
    });
}

// Mostrar modal de permisos
function mostrarModalPermisos(usuario, id) {
    $('#exampleModal').modal('show');
    $('#usuario').html(usuario);
    $('#usuario_select').val(id);
}

// Mostrar modal para crear un nuevo usuario
function mostrarModalCrearUsuario() {
    $('#createModal').modal('show');
}

// Crear un nuevo usuario
function crearUsuario() {
    let datos = {
        codigo: $('#create_codigo').val(),
        usuario: $('#create_usuario').val(),
        password: $('#create_password').val(),
        rol_id: $('#create_rol_id').val(),
    };
    $.ajax({
        type: 'POST',
        url: 'ajax.php',
        data: { accion: "crear_usuario", datos: datos },
        success: function (response) {
            $('#createModal').modal('hide');
            let mensaje = JSON.parse(response);
            alerta(mensaje.icon, mensaje.title, mensaje.text);
            mostrarUsuarios();
        }
    });
}

// Mostrar modal para editar usuario
function mostrarModalEditarUsuario(usuarioId) {
    $.ajax({
        type: 'POST',
        url: 'ajax.php',
        data: { accion: 'usuario_seleccionado', usuario_id: usuarioId },
        success: function(response) {
            const usuario = JSON.parse(response)[0];

            $('#edit_id').val(usuario.id);
            $('#edit_codigo').val(usuario.codigo);
            $('#edit_usuario').val(usuario.usuario);

            $('#editModal').modal('show');
        }
    });
}

// Guardar cambios del usuario editado
function guardarCambiosUsuario() {
    let formData = {
        usuario_id: $('#edit_id').val(),
        codigo: $('#edit_codigo').val(),
        usuario: $('#edit_usuario').val(),
        rol: $('#edit_rol_id').val(),
        estado: $('#edit_active').val(),
        password: $('#edit_password').val() // Obtener la nueva contraseña
    };

    // Verificar si se proporcionó una nueva contraseña y si tiene más de 7 caracteres
    if (formData.password && formData.password.length > 7) {
        formData.password = formData.password; // Encriptar con php password default
    } else {
        delete formData.password;
    }

    $.ajax({
        type: 'POST',
        url: 'ajax.php',
        data: { accion: 'editar_usuario', formData: formData },
        success: function (response) {
            let mensaje = JSON.parse(response);
            alerta(mensaje.icon, mensaje.title, mensaje.text);
            $('#editModal').modal('hide');
            mostrarUsuarios();
        }
    });
}


function alerta(icono, titulo, texto) {
    Swal.fire({
        icon: icono,
        title: titulo,
        text: texto,
        showConfirmButton: false,
        timer: 1500
    });
}
