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
</body>
<?php

//** FOOTER *//
require_once './../../components/footer/default.php';

?>