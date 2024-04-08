<?php

//** HEADER *//
require_once './../../components/header/default.php';

?>
<style>
    .verde-clarito {
        background-color: #E9FFEA !important;
        /* Verde */
    }

    .rojo-clarito {
        background-color: #FFEBE7 !important;
        /* Rojo */
    }
</style>

<body class="bg-body-secondary">


    <?php require_once './../../components/shared/navbar.php'; ?>


    <div>
        <div class="row mt-3 m-3">
            <div class="col-3 mt-2 pt-2">
                <!-- Breadcrumb deberia ir aca -->
                <?php require_once './../../components/shared/breadcrumb.php'; ?>
            </div>
            <div class="col-6 mt-2 pt-2 text-center"></div>
            <div class="col-3 mt-2 pt-3 text-end">
                <!-- Area para botones en la parte de arriba -->
                <button class="btn btn-primary" id="crearModulo">Crear Modulo</button>
            </div>
        </div>
    </div>

    <!-- Aquí va el contenido específico del módulo -->
    <div class="p-4 m-4 bg-white rounded">
        <h3 class="text-center mt-3">Sistema de Modulos</h3>
        <div class="table-responsive mt-5">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Nombre</th>
                        <th class="text-center">Orden</th>
                        <th>Padre</th>
                        <th>Ruta</th>
                        <th class="text-center">Activo</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody id="tbody_modulos">
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal para crear módulo -->
    <div class="modal fade" id="modalCrearModulo" tabindex="-1" aria-labelledby="modalCrearModuloLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCrearModuloLabel">Crear Módulo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formCrearModulo">
                        <div class="mb-3">
                            <label for="nombreModuloCrear" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombreModuloCrear" name="nombre_modulo" required>
                        </div>
                        <div class="mb-3">
                            <label for="ordenModuloCrear" class="form-label">Orden</label>
                            <input type="number" class="form-control" id="ordenModuloCrear" name="orden" required>
                        </div>
                        <div class="mb-3">
                            <label for="rutaModuloCrear" class="form-label">Ruta</label>
                            <input type="text" class="form-control" id="rutaModuloCrear" name="ruta" required>
                        </div>
                        <div class="mb-3">
                            <label for="tipoModuloCrear" class="form-label">Tipo</label>
                            <select name="tipoModuloCrear" class="form-control">
                                <option value="1">Primario</option>
                                <option value="2">Secundario</option>
                            </select>
                        </div>
                        <div class="mb-3" id="divModuloPadreCrear" style="display: none;">
                            <label for="padreIdModuloCrear" class="form-label">Módulo Padre</label>
                            <select class="form-control" id="padreIdModuloCrear" name="padre_id">
                                <!-- Las opciones se cargarán dinámicamente -->
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" id="btnGuardarCrear" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar módulo -->
    <div class="modal fade" id="modalEditarModulo" tabindex="-1" aria-labelledby="modalEditarModuloLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarModuloLabel">Editar Módulo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditarModulo">
                        <div class="mb-3">
                            <label for="nombreModuloEditar" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombreModuloEditar" name="nombre_modulo" required>
                        </div>
                        <div class="mb-3">
                            <label for="ordenModulEditear" class="form-label">Orden</label>
                            <input type="number" class="form-control" id="ordenModuloEditar" name="orden" required>
                        </div>
                        <div class="mb-3">
                            <label for="rutaModuloEditar" class="form-label">Ruta</label>
                            <input type="text" class="form-control" id="rutaModuloEditar" name="ruta" required>
                        </div>
                        <div class="mb-3">
                            <label for="tipoModuloEditar" class="form-label">Tipo</label>
                            <select name="tipoModuloEditar" class="form-control">
                                <option value="1">Primario</option>
                                <option value="2">Secundario</option>
                            </select>
                        </div>
                        <div class="mb-3" id="divModuloPadreEditar" style="display: none;">
                            <label for="padreIdModuloEditar" class="form-label">Módulo Padre</label>
                            <select class="form-control" id="padreIdModuloEditar" name="padre_id">
                                <!-- Las opciones se cargarán dinámicamente -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="activoModuloEditar" class="form-label">Activo</label>
                            <select name="activoModuloEditar" class="form-control">
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>
</body>
<?php

//** FOOTER *//
require_once './../../components/footer/core_footer.php';

?>