'use strict';

$(document).ready(function () {
    $('#crearModulo').click(function () {
        mostrarModalCrearUsuario();
    });
});
mostrarUsuarios();
// Evento de teclado en el input de búsqueda
$('#busqueda').keyup(function () {
    let valorBusqueda = $(this).val();
    mostrarUsuarios(valorBusqueda); // Pasar el término de búsqueda a la función
});

// Cargar los roles al abrir el modal de crear usuario
function cargarRoles() {
    console.log("Cargando roles..."); // Para depuración

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
            $('#create_rol_id').html(opcionesRoles); // Para el modal de crear usuario
            $('#edit_rol_id').html(opcionesRoles); // Para el modal de editar usuario
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
            let resultadosEncontrados = false; // verificar si se encontraron resultados

            usuarios.forEach(usuario => {
                if (usuario.usuario.includes(busqueda) || usuario.codigo.includes(busqueda)) {
                    resultadosEncontrados = true; // Se encontraron resultados
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
                $('#tablebody').html(filasUsuarios); // Mostrar los resultados
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

function cargarModulos(usuarioId) {
    $.ajax({
        type: 'POST',
        url: 'ajax.php',
        data: { accion: 'mostrar_modulos' },
        success: function (modulosResponse) {
            const modulos = JSON.parse(modulosResponse);
            // Filtrar solo módulos padres
            const modulosPadres = modulos.filter(modulo => modulo.padre_id === null);
            $('#accordionPermisos').empty(); // Limpiar el acordeón antes de cargar nuevos módulos

            // Iterar sobre módulos padres para construir acordeón
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
                cargarSubmodulos(moduloPadre.id, usuarioId); // Llamada a cargar submódulos
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
            }
        });
    }
}

// Función para seleccionar o deseleccionar ambos permisos
function seleccionarAmbos(submoduloId) {
    const lecturaCheck = $(`#lectura-${submoduloId}`);
    const escrituraCheck = $(`#escritura-${submoduloId}`);
    const ambosCheck = $(`#ambos-${submoduloId}`).is(':checked');

    lecturaCheck.prop('checked', ambosCheck);
    escrituraCheck.prop('checked', ambosCheck);
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
