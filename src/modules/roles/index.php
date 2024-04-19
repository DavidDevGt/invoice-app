<?php

//** HEADER *//
require_once './../../components/header/default.php';

?>

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
                <button class="btn btn-primary" id="crearModulo">Crear Rol</button>
            </div>
        </div>
    </div>

    <!-- Aquí va el contenido específico del módulo -->
    <div class="p-4 m-4 bg-white rounded">
        <div class="table-responsive">
            <table class="table table-hover table-striped fs-14">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Activo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="contenido_roles"></tbody>
            </table>
        </div>
    </div>

    <!-- Modal Agregar Rol -->
    <div class="modal fade" id="modal_agregar_rol" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Rol</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-3 form-group">
                        <label class="mb-2" for="codigo">Nombre</label>
                        <input type="text" id="codigo" maxlength="255" class="form-control">
                    </div>
                    <div class="mt-3 form-group">
                        <label class="mb-2" for="nombre">Descripción</label>
                        <input type="text" id="nombre" maxlength="255" class="form-control">
                    </div>
                    <div class="mt-3 form-group">
                        <label class="mb-2" for="observaciones">Activo</label>
                        <input type="text" id="observaciones" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="guardarRol()">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar Rol -->
    <div class="modal fade" id="modal_editar_rol" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Rol</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-3 form-group">
                        <label class="mb-2" for="ucodigo">Nombre</label>
                        <input type="text" id="ucodigo" maxlength="255" class="form-control">
                    </div>
                    <div class="mt-3 form-group">
                        <label class="mb-2" for="unombre">Descripción</label>
                        <input type="text" id="unombre" maxlength="255" class="form-control">
                    </div>
                    <div class="mt-3 form-group">
                        <label class="mb-2" for="uobservaciones">Activo</label>
                        <input type="text" id="uobservaciones" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>

</body>
<?php

//** FOOTER *//
require_once './../../components/footer/core_footer.php';

?>