'use strict';

$(document).ready(function () {

    mostrar_usuarios();
    mostrar_modulos();
    Search();
    CloseCollapse();
});


// genera el id del usuario, abre modal.
function PermisosShow(usuario, id) {
    $('#exampleModal').modal('show');
    $('#usuario').html(usuario);
    $('#usuario_select').val(id);

}

function createModal() {
    $('#createModal').modal('show');
}

function nuevo_usuario() {
    var nombre = $('#create_nombre').val();
    var apellidos = $('#create_apellidos').val();
    var codigo = $('#create_codigo').val();
    var usuario = $('#create_usuario').val();
    var password = $('#create_password').val();
    var email = $('#create_email').val();
    var tel1 = $('#create_tel1').val();
    var tel2 = $('#create_tel2').val();
    var rol = $('#rol_2').val();
    var estado = $('#create_estado').val();

    var Data = {
        nombres: nombre,
        apellidos: apellidos,
        usuario: usuario,
        codigo: codigo,
        password: password,
        email: email,
        cempresa: tel1,
        cpersonal: tel2,
        rol: rol,
        estado: estado,
        uuser: 1
    };

    $.ajax({
        type: 'POST',
        url: 'ajax.php',
        data: { fnc: "crear_usuario", datos: Data },
        success: function (response) {
            $('#createModal').modal('hide');
            console.log(response);
            let mensaje = JSON.parse(response);
            Swal.fire({
                icon: mensaje.icon,
                title: mensaje.title,
                text: mensaje.text,
                showConfirmButton: false,
                timer: 1500
            });
            mostrar_usuarios();
        }

    });

}

//cuando se cierre un modal recarga 
function CloseCollapse() {
    $('#exampleModal').on('hidden.bs.modal', function (e) {
        $(this).find('.collapse').collapse('hide');
        Swal.fire({
            icon: 'success',
            title: 'Guardando',
            showConfirmButton: false,
            timer: 500
        });
    });
}

// busca en la tabla
function Search() {
    $('#busqueda').on('input', function () {
        var valorBusqueda = $(this).val().toLowerCase();
        $('#tabla tbody tr').each(function () {
            var textoFila = $(this).text().toLowerCase();
            if (textoFila.indexOf(valorBusqueda) === -1) {
                $(this).hide();
            } else {
                $(this).show()  ;
            }
        });
    });
}


function mostrar_usuarios() {
    $.ajax({
        type: "POST",
        url: "ajax.php",
        data: { fnc: "mostrar_usuarios" },
        success: function (response) {
            let usuarios = JSON.parse(response);
            let userRows = '';

            usuarios.forEach(usuario => {
                let estado = usuario.active == 1 ? 'Activo' : 'Inactivo';
                let ClassColor = usuario.active == 1 ? 'text-success' : 'text-danger';

                userRows += `
                    <tr>
                        <td scope="row">${usuario.id}</td>
                        <td>${usuario.codigo}</td>
                        <td>${usuario.usuario_nombre}</td>
                        <td>${usuario.usuario}</td>
                        <td>${usuario.correo}</td>
                        <td>${usuario.celular}</td>
                        <td>${usuario.nombre_rol}</td>
                        <td class="${ClassColor}" >${estado}</td>
                        <td>
                            <button type="button" onclick="PermisosShow('${usuario.usuario_nombre}',${usuario.id})" data-user-id="${usuario.id}" title="Permisos" class="btn btn-warning"><i class="bi bi-key-fill"></i></button>
                            <button type="button" onclick="mostrar_usuarios_select_edit(${usuario.id})" data-user-id="${usuario.id}" title="Editar" class="btn btn-primary"><i class="bi bi-pencil-square"></i></button>
                        </td>
                    </tr>
                `;
            });

            $('#tablebody').html(userRows);
        }
    });
}

function mostrar_usuarios_select_edit(usuario_id) {
    let user = usuario_id;
    $.ajax({
        type: "POST",
        url: "ajax.php",
        data: { fnc: "usuario_seleccionado", usuario_id: user },
        success: function (response) {
            let usuarios = JSON.parse(response);
            let userRows = '';

            usuarios.forEach(usuario => {
                let estado = usuario.active == 1 ? '<option value="1" selected>Activo</option><option value="0">Inactivo</option>' : '<option value="0" selected>Inactivo</option><option value="1">Activo</option>';
                userRows += `
                <form class="row row-cols-2">
                    <input type="hidden" class="form-control" id="usuario_edit_id" autocomplete="off"
                        value="${usuario.id}">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombres</label>
                        <input type="text" class="form-control" id="nombre" autocomplete="off"
                            value="${usuario.nombres}">
                    </div>
                    <div class="mb-3">
                        <label for="apellidos" class="form-label">Apellidos</label>
                        <input type="text" class="form-control" id="apellidos" autocomplete="off"
                            value="${usuario.apellidos}">
                    </div>
                    <div class="mb-3">
                        <label for="usuario" class="form-label">Usuario</label>
                        <input type="text" class="form-control" id="usuario_edit" autocomplete="off"
                            value="${usuario.usuario}">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" autocomplete="off"
                            value="">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input type="email" class="form-control" id="email" autocomplete="off"
                            value="${usuario.correo}">
                    </div>
                    <div class="mb-3">
                        <label for="tel1" class="form-label">Celular Empresa</label>
                        <input type="tel" class="form-control" id="tel1" autocomplete="off"
                            value="${usuario.celular_e}">
                    </div>
                    <div class="mb-3">
                        <label for="tel2" class="form-label">Celular Personal</label>
                        <input type="tel" class="form-control" id="tel2" autocomplete="off"
                            value="${usuario.celular_p}">
                    </div>
                    <div class="mb-3">
                        <label for="rol" class="form-label">Rol</label>
                        <select onclick="mostrarRoles()" class="form-control" name="rol" id="rol">
                            <option value="${usuario.rol_id}">${usuario.nombre_rol}</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-control" name="estado" id="estado">
                            ${estado}
                        </select>
                    </div>
                </form>
                <div class="mb-3 mt-4">
                    <button onclick="guardar_cambios_usuario()" class="btn btn-success" id="edit_save" type="submit">Guardar cambios</button>
                </div>
                `;
            });

            $('#form_edit').html(userRows);
            $('#editModal').modal('show');

        }
    });
}

let rolesCargados2 = false;

function mostrarRoles2() {
    if (!rolesCargados2) {
        $.ajax({
            type: "POST",
            url: "ajax.php",
            data: { fnc: "roles" },
            success: function (response) {
                let roles = JSON.parse(response);
                let opcionesRoles = '';
                roles.forEach(rol => {
                    opcionesRoles += `<option value="${rol.id}">${rol.nombre}</option>`;
                });
                $('#rol_2').html(opcionesRoles);
                rolesCargados2 = true;
            }
        });
    }
}


let rolesCargados = false;

function mostrarRoles() {
    // Verificar si los roles ya han sido cargados
    if (!rolesCargados) {
        $.ajax({
            type: "POST",
            url: "ajax.php",
            data: { fnc: "roles" },
            success: function (response) {
                let roles = JSON.parse(response);
                let opcionesRoles = '';
                roles.forEach(rol => {
                    opcionesRoles += `<option value="${rol.id}">${rol.nombre}</option>`;
                });
                $('#rol').html(opcionesRoles);
                rolesCargados = true;
            }
        });
    }
}




function mostrar_modulos() {
    $.ajax({
        type: "POST",
        url: "ajax.php",
        data: { fnc: "mostrar_modulos" },
        success: function (response) {
            let infoModulos = JSON.parse(response);
            let modulosRow = '';

            infoModulos.forEach(modulo => {

                modulosRow += `
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button onclick="mostrar_modulos_hijo(${modulo.id})" class="accordion-button fw-semibold collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#modulopadre${modulo.id}">
                            <i class="bi bi-caret-right-fill"></i> &nbsp; ${modulo.nombre}
                        </button>
                    </h2>
                    <div id="modulopadre${modulo.id}" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between">
                                    <label class="form-check-label w-100" for="submodulo">test</label>
                                    <input class="form-check-input" type="checkbox" value="" id="submodulo">
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                `;
            });

            $('#modulos').html(modulosRow);
        }
    });
}


function mostrar_modulos_hijo(modulo_padre, usuario) {
    $.ajax({
        type: "POST",
        url: "ajax.php",
        data: { fnc: "mostrar_modulos_hijo", padre: modulo_padre },
        success: function (response) {
            let infoModulosHijo = JSON.parse(response);
            let modulosHRow = '';

            modulosHRow += `
            <div class="accordion-body">
                <ul class="list-group">
            `;

            infoModulosHijo.forEach(submodulo => {
                modulosHRow += `
                        <li class="list-group-item d-flex justify-content-between">
                            <label class="form-check-label w-100" for="submodulo${submodulo.id}">${submodulo.nombre}</label>
                            <input onchange="guardar_permisos(this)" data-padre="${submodulo.padre}" class="form-check-input" type="checkbox" value="${submodulo.id}" id="submodulo${submodulo.id}">
                        </li>
                `;
            });
            modulosHRow += `
                </ul>
            </div>
        `;

            $('#modulopadre' + modulo_padre).html(modulosHRow);
            mostrar_modulos_hijo_usuario();
        }
    });
}

function mostrar_modulos_hijo_usuario() {
    let usuario_id = $('#usuario_select').val();
    $.ajax({
        type: "POST",
        url: "ajax.php",
        data: { fnc: "mostrar_modulos_hijo_usuario", usuario: usuario_id },
        success: function (response) {
            var modulos = JSON.parse(response);
            modulos.forEach(function (modulo) {
                $("#submodulo" + modulo.modulo_id).prop("checked", true);
            });
        }
    });
}

function guardar_permisos(element) {
    let modulo = $(element).val();
    let padre = $(element).data('padre');
    let usuario = $('#usuario_select').val();
    $.ajax({
        type: "POST",
        url: "ajax.php",
        data: { fnc: "guardar_permisos", modulo: modulo, usuario: usuario, padre: padre },
        success: function (response) {
            console.log(response);
        }
    });
}


function guardar_cambios_usuario() {
    let usuario_id = $("#usuario_edit_id").val();
    let nombres = $("#nombre").val();
    let apellidos = $("#apellidos").val();
    let correo = $("#email").val();
    let usuario = $("#usuario_edit").val();
    let celular_e = $("#tel1").val();
    let celular_p = $("#tel2").val();
    let rol = $("#rol").find(":selected").val();
    let estado = $("#estado").val();


    let formData = {
        usuario_id: usuario_id,
        nombres: nombres,
        apellidos: apellidos,
        usuario: usuario,
        correo: correo,
        celular_e: celular_e,
        celular_p: celular_p,
        rol: rol,
        estado: estado
    };

    console.log(formData);

    $.ajax({
        type: "POST",
        url: "ajax.php",
        data: { fnc: "editar_usuario", formData: formData },
        success: function (response) {
            $('#editModal').modal('hide');
            console.log(response);
            let mensaje = JSON.parse(response);
            Swal.fire({
                icon: mensaje.icon,
                title: mensaje.title,
                text: mensaje.text,
                showConfirmButton: false,
                timer: 1500
            });
            mostrar_usuarios();
            CloseCollapse();
        }
    });
}




