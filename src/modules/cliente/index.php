<?php

//** HEADER *//
require_once './../../components/header/default.php';

//** SECURITY *//
require_once './../../components/security/middleware.php';
?>

<body class="bg-body-secondary">

    <?php require_once './../../components/shared/navbar.php'; ?>

    <div>
        <div class="row mt-3 m-4">
            <div class="col-3 mt-2 pt-3">
                <!-- Breadcrumb deberia ir aca -->
                <?php require_once './../../components/shared/breadcrumb.php'; ?>
            </div>
            <div class="col-3 mt-2 pt-3 text-center"></div>
            <div class="col-6 mt-2 pt-3 text-end">
                <!-- Area para botones en la parte de arriba -->
            </div>
        </div>
    </div>


    <!-- Contenido específico del módulo -->
    <div class="p-4 m-4 bg-white rounded"></div>

</body>

<?php

//** FOOTER *//
require_once './../../components/footer/default.php';

?>