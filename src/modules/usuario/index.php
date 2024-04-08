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
                <button class="btn btn-primary" id="crearModulo">Crear Usuario</button>
            </div>
        </div>
    </div>


    <!-- Aquí va el contenido específico del módulo -->
    <div class="p-4 m-4 bg-white rounded">
        <!-- Titulo -->
        <section class="container mt-5">
            <div class="row">
                <div class="col-md-6">
                    <h3>Usuarios</h3>
                </div>
                <div class="col-md-6">
                    <input class="form-control w-100" type="text" id="busqueda" placeholder="Buscar por codigo o username...">
                </div>
            </div>

            <hr class="mt-4 mb-4">
            <!-- Insert de tabla de datos -->
            <table id="tabla" class="table table-bordered table-striped">
                <thead>
                    <tr class="table-dark text-center">
                        <th scope="col">ID</th>
                        <th scope="col">Código</th>
                        <th scope="col">Usuario</th>
                        <th scope="col">Rol</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-center" id="tablebody">

                </tbody>
            </table>
            <!-- fin de tabla de datos -->
        </section>
    </div>

    <!-- Modal de permisos de usuario -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body border-0">
                    <div class="modal-header border-0">
                        <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="bi bi-key-fill"></i> &nbsp; Permisos de <span id="usuario"></span></h1>
                        <input type="hidden" id="usuario_select">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <hr>
                    <div class="accordion" id="accordionPermisos">
                        <!-- Los módulos se cargarán aquí dinámicamente -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de editar usuario -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulario de edición de usuario -->
                    <form id="form_editar_usuario">
                        <input type="hidden" id="edit_id"> <!-- ID oculto del usuario -->
                        <div class="mb-3">
                            <label for="edit_codigo" class="form-label">Código</label>
                            <input type="text" class="form-control" id="edit_codigo">
                        </div>
                        <div class="mb-3">
                            <label for="edit_usuario" class="form-label">Usuario</label>
                            <input type="text" class="form-control" id="edit_usuario">
                        </div>
                        <div class="mb-3">
                            <label for="edit_password" class="form-label">Nueva Contraseña</label>
                            <input type="password" class="form-control" id="edit_password">
                        </div>
                        <div class="mb-3">
                            <label for="edit_rol_id" class="form-label">Rol</label>
                            <select class="form-select" id="edit_rol_id">
                                <option value="">Seleciona un rol</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_active" class="form-label">Estado</label>
                            <select class="form-select" id="edit_active">
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="guardarCambiosUsuario()">Guardar cambios</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de crear usuario -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body border-0">
                    <div class="modal-header border-0">
                        <h1 class="modal-title fs-5" id="createModalLabel"><i class="bi bi-key-fill"></i> &nbsp; Agregar usuario <span id="usuario"></span></h1>
                        <input type="hidden" id="usuario_select_edit">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <hr>
                    <div class="formulario p-3" id="create_form">
                        <form class="row row-cols-2">
                            <div class="mb-3">
                                <label for="usuario" class="form-label">Usuario</label>
                                <input type="text" class="form-control" placeholder="Introduce el username" id="create_usuario" autocomplete="off" value="">
                            </div>
                            <div class="mb-3">
                                <label for="usuario" class="form-label">Código</label>
                                <input type="text" class="form-control" id="create_codigo" placeholder="Introduce el código" value="">
                            </div>
                            <div class="mb-3">
                                <label for="text" class="form-label">Contraseña</label>
                                <input type="text" class="form-control" id="create_password" placeholder="Introduce la contraseña" value="">
                            </div>
                            <div class="mb-3">
                                <label for="create_rol_id" class="form-label">Rol</label>
                                <select class="form-control" name="create_rol_id" id="create_rol_id">
                                    <option value="">Seleciona un rol</option>
                                </select>
                            </div>
                        </form>
                        <div class="mb-3 mt-4">
                            <button onclick="crearUsuario()" class="btn btn-success" id="create_save" type="button">Crear usuario</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php

//** FOOTER *//
require_once './../../components/footer/default.php';

?>