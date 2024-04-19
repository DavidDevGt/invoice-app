'use strict';

$(document).ready(function () {
    verifyToken();

    $('#crearModulo').click(function () {
        mostrarModalCrearUsuario();
    });
});

mostrarUsuarios();

$('#busqueda').keyup(function () {
    let valorBusqueda = $(this).val();
    mostrarUsuarios(valorBusqueda);
});

$('.btn-guardar-permisos').click(function () {
    guardarCambiosPermisos();
});

function cargarRoles() {
    // console.log("Cargando roles...");

    $.ajax({
        type: 'POST',
        url: 'ajax.php',
        data: { accion: "mostrar_roles" },
        success: function (response) {
            const roles = JSON.parse(response);
            let opcionesRoles = '<option value="">Seleccione un rol</option>';
            roles.forEach(rol => {
                opcionesRoles += `<option value="${rol.id}">${rol.nombre}</option>`;
            });
            $('#create_rol_id').html(opcionesRoles);
            $('#edit_rol_id').html(opcionesRoles);
        }
    });
}

function mostrarUsuarios(busqueda = '') {
    $.ajax({
        type: "POST",
        url: "ajax.php",
        data: { accion: "mostrar_usuarios" },
        success: function (response) {
            let usuarios = JSON.parse(response);
            let filasUsuarios = '';
            let resultadosEncontrados = false;

            usuarios.forEach(usuario => {
                if (usuario.usuario.includes(busqueda) || usuario.codigo.includes(busqueda)) {
                    resultadosEncontrados = true;
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
                }
            });

            if (resultadosEncontrados) {
                $('#tablebody').html(filasUsuarios);
            } else {
                $('#tablebody').html(`<tr><td colspan="6" class="text-center">No se encontraron resultados</td></tr>`);
            }
        }
    });
}


function mostrarModalPermisos(usuario, id) {
    $('#exampleModal').modal('show');
    $('#usuario').html(usuario);
    $('#usuario_select').val(id);
    cargarModulos(id);
}

function cargarPermisosUsuario(usuarioId) {
    $.ajax({
        type: 'POST',
        url: 'ajax.php',
        data: { accion: 'cargar_permisos_usuario', usuario_id: usuarioId },
        success: function (response) {
            // console.log("Respuesta recibida:", response);

            try {
                const permisos = JSON.parse(response);

                Object.keys(permisos).forEach(function (moduloId) {
                    const permiso = permisos[moduloId];
                    const lecturaCheckbox = $(`#lectura-${moduloId}`);
                    const escrituraCheckbox = $(`#escritura-${moduloId}`);
                    const ambosCheckbox = $(`#ambos-${moduloId}`);

                    if (permiso.lectura == 1) {
                        lecturaCheckbox.prop('checked', true);
                    }

                    if (permiso.escritura == 1) {
                        escrituraCheckbox.prop('checked', true);
                    }

                    if (permiso.lectura == 1 && permiso.escritura == 1) {
                        ambosCheckbox.prop('checked', true);
                    }
                });
            } catch (error) {
                console.error("Error al procesar la respuesta JSON:", error);
            }
        },
        error: function (xhr, status, error) {
            console.error("Error en la solicitud AJAX: " + status + " - " + error);
        }
    });
}

function cargarModulos(usuarioId) {
    $.ajax({
        type: 'POST',
        url: 'ajax.php',
        data: { accion: 'mostrar_modulos' },
        success: function (modulosResponse) {
            const modulos = JSON.parse(modulosResponse);
            const modulosPadres = modulos.filter(modulo => modulo.padre_id === null);
            $('#accordionPermisos').empty(); // Limpiar

            modulosPadres.forEach((moduloPadre, index) => {
                const moduloId = `modulo-${moduloPadre.id}`;
                let moduloHtml = `
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading${moduloId}">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${moduloId}" aria-expanded="${index === 0}" aria-controls="collapse${moduloId}">
                                ${moduloPadre.nombre}
                            </button>
                        </h2>
                        <div id="collapse${moduloId}" class="accordion-collapse collapse ${index === 0 ? 'show' : ''}" aria-labelledby="heading${moduloId}" data-bs-parent="#accordionPermisos">
                            <div class="accordion-body" id="modulosHijos-${moduloPadre.id}">
                                <!-- Submódulos se cargarán aquí -->
                            </div>
                        </div>
                    </div>
                `;
                $('#accordionPermisos').append(moduloHtml);
                cargarSubmodulos(moduloPadre.id, usuarioId); // Cargar submódulos
            });
        }
    });
}

function cargarSubmodulos(moduloPadreId, usuarioId) {
    if (!$(`#modulosHijos-${moduloPadreId}`).hasClass('loaded')) {
        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            data: { accion: 'mostrar_modulos_hijo', modulo_padre_id: moduloPadreId },
            success: function (submodulosResponse) {
                const submodulos = JSON.parse(submodulosResponse);
                let submodulosHtml = '<hr> ';
                submodulos.forEach(submodulo => {
                    submodulosHtml += `
                        <div class="row align-items-center mb-2">
                            <div class="col">
                                <span>${submodulo.nombre}</span>
                            </div>
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="lectura-${submodulo.id}" name="permisos[${submodulo.id}][lectura]">
                                    <label class="form-check-label" for="lectura-${submodulo.id}">Lectura</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="escritura-${submodulo.id}" name="permisos[${submodulo.id}][escritura]">
                                    <label class="form-check-label" for="escritura-${submodulo.id}">Escritura</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="ambos-${submodulo.id}" onchange="seleccionarAmbos(${submodulo.id})">
                                    <label class="form-check-label" for="ambos-${submodulo.id}">Todos</label>
                                </div>
                            </div>
                        </div>
                        <hr>
                    `;
                });
                $(`#modulosHijos-${moduloPadreId}`).addClass('loaded').html(submodulosHtml);
                cargarPermisosUsuario(usuarioId);
            }
        });
    }
}

// Definir la variable permisos antes de usar la función seleccionarAmbos
var permisos = {};

function seleccionarAmbos(submoduloId) {
    const lecturaCheck = $(`#lectura-${submoduloId}`);
    const escrituraCheck = $(`#escritura-${submoduloId}`);
    const ambosCheck = $(`#ambos-${submoduloId}`).is(':checked');

    lecturaCheck.prop('checked', ambosCheck);
    escrituraCheck.prop('checked', ambosCheck);

    // Actualizar los permisos en el objeto `permisos` si es necesario
    if (permisos[submoduloId]) {
        permisos[submoduloId]['lectura'] = ambosCheck ? 1 : 0;
        permisos[submoduloId]['escritura'] = ambosCheck ? 1 : 0;
    }
}



function guardarCambiosPermisos() {
    const usuarioId = $('#usuario_select').val();
    const permisos = {};

    // Recorrer todos los checkboxes de permisos y guardar su estado
    $('input[type="checkbox"]').each(function () {
        const id = $(this).attr('id').split('-')[1];
        const tipoPermiso = $(this).attr('id').split('-')[0];
        const isChecked = $(this).is(':checked');

        if (!permisos[id]) {
            permisos[id] = { 'module_id': id };
        }

        if (tipoPermiso === 'lectura') {
            permisos[id]['lectura'] = isChecked ? 1 : 0;
        } else if (tipoPermiso === 'escritura') {
            permisos[id]['escritura'] = isChecked ? 1 : 0;
        }
    });

    $.ajax({
        type: 'POST',
        url: 'ajax.php',
        data: { accion: 'actualizar_permisos', usuario_id: usuarioId, permisos: permisos },
        success: function (response) {
            const resultado = JSON.parse(response);
            if (resultado.success) {
                alerta('success', '¡Éxito!', 'Los permisos se han actualizado correctamente.');
                $('#exampleModal').modal('hide');
            } else {
                alerta('error', '¡Error!', 'Hubo un error al actualizar los permisos.');
            }
        },
        error: function (xhr, status, error) {
            console.error("Error en AJAX: " + status + " - " + error);
            alerta('error', '¡Error!', 'Hubo un error al actualizar los permisos.');
        }
    });
}

// Mostrar modal para crear un nuevo usuario
function mostrarModalCrearUsuario() {
    $('#createModal').modal('show');
    cargarRoles();
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
        },
        error: function (xhr, status, error) {
            console.error("Error en AJAX: " + status + " - " + error);
        }
    });
}

// Mostrar modal para editar usuario
function mostrarModalEditarUsuario(usuarioId) {
    $.ajax({
        type: 'POST',
        url: 'ajax.php',
        data: { accion: 'usuario_seleccionado', usuario_id: usuarioId },
        success: function (response) {
            const usuario = JSON.parse(response)[0];
            $('#edit_id').val(usuario.id);
            $('#edit_codigo').val(usuario.codigo);
            $('#edit_usuario').val(usuario.usuario);
            $('#edit_rol_id').val(usuario.rol_id).change();
            $('#edit_active').val(usuario.active.toString());
            $('#editModal').modal('show');
            cargarRoles();
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
        password: $('#edit_password').val()
    };

    if (!formData.password || formData.password.length <= 7) {
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
