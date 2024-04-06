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
                    <input class="form-control w-100" type="text" id="busqueda" placeholder="Buscar...">
                </div>
            </div>

            <hr class="mt-4 mb-4">
            <!-- Insert de tabla de datos -->
            <table id="tabla" class="table table-bordered table-striped">
                <thead>
                    <tr class="table-dark">
                        <th scope="col">ID</th>
                        <th scope="col">Código</th>
                        <th scope="col">Usuario</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Celular</th>
                        <th scope="col">Rol</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody id="tablebody">

                </tbody>
            </table>
            <!-- fin de tabla de datos -->
        </section>


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
                        <div class="accordion" id="modulos">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de permisos de usuario -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body border-0">
                        <div class="modal-header border-0">
                            <h1 class="modal-title fs-5" id="editModalLabel"><i class="bi bi-key-fill"></i> &nbsp; Editar <span id="usuario"></span></h1>
                            <input type="hidden" id="usuario_select_edit">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <hr>
                        <div class="formulario p-3" id="form_edit">
                        </div>
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
                                    <label for="nombre" class="form-label">Nombres</label>
                                    <input type="text" class="form-control" id="create_nombre" autocomplete="off" value="">
                                </div>
                                <div class="mb-3">
                                    <label for="apellidos" class="form-label">Apellidos</label>
                                    <input type="text" class="form-control" id="create_apellidos" autocomplete="off" value="">
                                </div>
                                <div class="mb-3">
                                    <label for="usuario" class="form-label">Usuario</label>
                                    <input type="text" class="form-control" id="create_usuario" autocomplete="off" value="">
                                </div>
                                <div class="mb-3">
                                    <label for="usuario" class="form-label">Código</label>
                                    <input type="text" class="form-control" id="create_codigo" autocomplete="off" value="">
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Contraseña</label>
                                    <input type="text" class="form-control" id="create_password" autocomplete="off" value="">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Correo electrónico</label>
                                    <input type="email" class="form-control" id="create_email" autocomplete="off" value="">
                                </div>
                                <div class="mb-3">
                                    <label for="tel1" class="form-label">Celular Empresa</label>
                                    <input type="tel" class="form-control" id="create_tel1" autocomplete="off" value="">
                                </div>
                                <div class="mb-3">
                                    <label for="tel2" class="form-label">Celular Personal</label>
                                    <input type="tel" class="form-control" id="create_tel2" autocomplete="off" value="">
                                </div>
                                <div class="mb-3">
                                    <label for="rol" class="form-label">Rol</label>
                                    <select onclick="mostrarRoles2()" class="form-control" name="rol" id="rol_2">
                                        <option value="">Seleciona un rol</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="estado" class="form-label">Estado</label>
                                    <select class="form-control" name="estado" id="create_estado">
                                        <option value="1">Activo</option>
                                        <option value="0">Inactivo</option>
                                    </select>
                                </div>
                            </form>
                            <div class="mb-3 mt-4">
                                <button onclick="nuevo_usuario()" class="btn btn-success" id="create_save" type="submit">Crear usuario</button>
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