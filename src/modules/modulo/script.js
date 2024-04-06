"use strict";

const tbody_modulos = $('#tbody_modulos');

const cargarModulos = () => {
    $.ajax({
        url: './ajax.php',
        type: 'POST',
        data: { accion: 'leer' },
        success: function (response) {
            const modulos = JSON.parse(response);
            modulos.forEach(modulo => {
                $('#tbody_modulos').append(
                    `<tr>
                        <td>${modulo.nombre}</td>
                        <td class="text-center">${modulo.orden}</td>
                        <td>${modulo.padre_id || 'N/A'}</td>
                        <td>${modulo.ruta}</td>
                        <td class="text-center">${modulo.active == 1 ? 'Sí' : 'No'}</td>
                        <td class="text-center">
                            <button class="btn btn-success btn-sm"><i class="fa-solid fa-pencil"></i></button>
                            <button class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></button>
                        </td> 
                     </tr>`
                );
            });
        },
        error: function (xhr, status, error) {
            console.error("Error al cargar módulos: ", error);
        }
    });
};

const nombreFuncion = () => { };

$(document).ready(function () {
    cargarModulos();
});