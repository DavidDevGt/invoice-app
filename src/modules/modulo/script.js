"use strict";

$(document).ready(function () {
    verifyToken();
    cargarModulos();

    $('#crearModulo').click(function () {
        $('#modalCrearModulo').modal('show');
    });

    $('#btnGuardarCrear').click(function () {
        $('#formCrearModulo').submit();
    });

    $('select[name="tipoModuloCrear"]').change(function () {
        const tipo = $(this).val();
        if (tipo == "2") { // Secundario
            cargarModulosPadre('#padreIdModuloCrear');
            $('#divModuloPadreCrear').show();
        } else {
            $('#divModuloPadreCrear').hide();
        }
    });

    $('select[name="tipoModuloEditar"]').change(function () {
        const tipo = $(this).val();
        if (tipo === "2") { // Si es un módulo hijo
            cargarModulosPadre('#padreIdModuloEditar');
            $('#divModuloPadreEditar').show();
        } else {
            $('#divModuloPadreEditar').hide();
        }
    });

    $(document).on('click', '.btn-editar-modulo', function () {
        const id = $(this).closest('tr').data('id');
        $.ajax({
            url: './ajax.php',
            type: 'POST',
            data: { accion: 'modulo_seleccionado', id: id },
            success: function (response) {
                const modulo = JSON.parse(response);
                $('#idModulo').val(modulo.id);
                $('#nombreModuloEditar').val(modulo.nombre);
                $('#ordenModuloEditar').val(modulo.orden);
                $('#rutaModuloEditar').val(modulo.ruta);
                $('select[name="activoModuloEditar"]').val(modulo.active.toString());

                if (modulo.padre_id) {
                    // Es un módulo hijo
                    $('select[name="tipoModuloEditar"]').val('2');
                    cargarModulosPadre('#padreIdModuloEditar', modulo.padre_id);
                    $('#divModuloPadreEditar').show();
                } else {
                    // Es un módulo padre
                    $('select[name="tipoModuloEditar"]').val('1');
                    $('#divModuloPadreEditar').hide();
                }
                $('#modalEditarModulo').modal('show');
            },
            error: function (xhr, status, error) {
                console.error("Error al cargar el módulo: ", error);
                alerta('error', 'Error al cargar el módulo', '');
            }
        });
    });

    $(document).on('click', '.btn-eliminar-modulo', function () {
        const id = $(this).closest('tr').data('id');
        eliminarModulo(id);
    });
});

const tbody_modulos = $('#tbody_modulos');
const form_crear_modulo = $('#formCrearModulo');
const btn_guardar_cambios = $('#guardar_cambios_modulo');

const cargarModulos = () => {
    $.ajax({
        url: './ajax.php',
        type: 'POST',
        data: { accion: 'leer' },
        success: function (response) {
            const modulos = JSON.parse(response);
            tbody_modulos.empty(); // Limpiar la tabla
            modulos.forEach(padre => {
                const activoClassPadre = padre.active == 1 ? 'verde-clarito' : 'rojo-clarito';
                tbody_modulos.append(
                    `<tr class="modulo_${padre.id}" data-id="${padre.id}">
                        <td>${padre.nombre}</td>
                        <td class="text-center">${padre.orden}</td>
                        <td>N/A</td>
                        <td>${padre.ruta}</td>
                        <td class="text-center ${activoClassPadre}">${padre.active == 1 ? 'Sí' : 'No'}</td>
                        <td class="text-center">
                            <button class="btn btn-success btn-sm btn-editar-modulo"><i class="fa-solid fa-pencil"></i></button>
                            <button class="btn btn-danger btn-sm btn-eliminar-modulo"><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>`
                );
                // Si el módulo padre tiene hijos, insertarlos debajo
                if (padre.hijos && padre.hijos.length > 0) {
                    padre.hijos.forEach(hijo => {
                        const activoClassHijo = hijo.active == 1 ? 'verde-clarito' : 'rojo-clarito';
                        tbody_modulos.append(
                            `<tr class="modulo_hijo_${hijo.id} modulo_padre_${padre.id}" data-id="${hijo.id}">
                                <td>-- ${hijo.nombre}</td>
                                <td class="text-center">${hijo.orden}</td>
                                <td>${padre.nombre}</td>
                                <td>${hijo.ruta}</td>
                                <td class="text-center ${activoClassHijo}">${hijo.active == 1 ? 'Sí' : 'No'}</td>
                                <td class="text-center">
                                    <button class="btn btn-success btn-sm btn-editar-modulo"><i class="fa-solid fa-pencil"></i></button>
                                    <button class="btn btn-danger btn-sm btn-eliminar-modulo"><i class="fa-solid fa-trash"></i></button>
                                </td>
                            </tr>`
                        );
                    });
                }
            });
        },
        error: function (xhr, status, error) {
            console.error("Error al cargar módulos: ", error);
        }
    });
};

function cargarModulosPadre(selector, selectedPadreId = null) {
    $.ajax({
        url: './ajax.php',
        type: 'POST',
        data: { accion: 'leer_modulos_primarios' },
        success: function (response) {
            const modulos = JSON.parse(response);
            const selectPadre = $(selector);
            selectPadre.empty();
            selectPadre.append('<option value="">Seleccione un módulo padre</option>');
            modulos.forEach(modulo => {
                const selected = modulo.id === selectedPadreId ? ' selected' : '';
                selectPadre.append(`<option value="${modulo.id}"${selected}>${modulo.nombre}</option>`);
            });
        },
        error: function (xhr, status, error) {
            console.error("Error al cargar módulos primarios: ", error);
        }
    });
}

form_crear_modulo.submit(function (e) {
    e.preventDefault();
    const formData = $(this).serialize() + '&accion=crear';

    $.ajax({
        url: './ajax.php',
        type: 'POST',
        data: formData,
        success: function (response) {
            const data = JSON.parse(response);
            if (data.success) {
                $('#modalCrearModulo').modal('hide');
                alerta('success', 'Éxito', data.success);
                cargarModulos();
            } else {
                alerta('error', 'Error', data.error);
            }
        },
        error: function (xhr, status, error) {
            console.error("Error al crear el módulo: ", error);
            alerta('error', 'Error al crear el módulo', '');
        }
    });
});

btn_guardar_cambios.click(function (e) {
    e.preventDefault(); // Previene la acción por defecto del formulario.
    const formData = $('#formEditarModulo').serialize() + '&accion=actualizar';
    
    $.ajax({
        url: './ajax.php',
        type: 'POST',
        data: formData,
        success: function (response) {
            const data = JSON.parse(response);
            if (data.success) {
                $('#modalEditarModulo').modal('hide');
                alerta('success', 'Éxito', data.success);
                cargarModulos(); // Recarga la lista de módulos
            } else {
                alerta('error', 'Error', data.error);
            }
        },
        error: function (xhr, status, error) {
            console.error("Error al actualizar el módulo: ", error);
            alerta('error', 'Error al actualizar el módulo', '');
        }
    });
});


const eliminarModulo = (id) => {
    $.ajax({
        url: './ajax.php',
        type: 'POST',
        data: { accion: 'eliminar', id: id },
        success: function (response) {
            Swal.fire('Eliminado!', 'El módulo ha sido eliminado.', 'success');
            cargarModulos(); // Recargar
        },
        error: function (xhr, status, error) {
            console.error("Error al eliminar el módulo: ", error);
            alerta('error', 'Error al eliminar el módulo', '');
        }
    });
};

function alerta(icono, titulo, texto) {
    Swal.fire({
        icon: icono,
        title: titulo,
        text: texto,
        showConfirmButton: true,
    });
}
