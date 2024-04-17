<?php

//** HEADER *//
require_once './../../components/header/default.php';

?>

<body class="bg-body-secondary">

    <?php require_once './../../components/shared/navbar.php'; ?>

    <div>
        <div class="row mt-3 m-4">
            <div class="col-3 mt-2 pt-3">
                <!-- Breadcrumb deberia ir aca -->
                <?php require_once './../../components/shared/breadcrumb.php'; ?>
            </div>
            <div class="col-6 mt-2 pt-3 text-center"></div>
            <div class="col-3 mt-2 pt-3 text-end">
                <!-- Area para botones en la parte de arriba -->
            </div>
        </div>
    </div>


    <!-- Aquí va el contenido específico del módulo -->
    <div class="p-4 m-4 bg-white rounded">
        <h1 class="text-center mt-3">Bienvenido</h1>

        <div class="table-responsive">
            <table id="dynamicTable" class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido</th>
                        <th scope="col">Edad</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Aquí se llenarán las filas de forma dinámica -->
                </tbody>
            </table>
        </div>
    </div>

</body>

<?php

//** FOOTER *//
require_once './../../components/footer/default.php';

?>

<script>
    $(document).ready(function() {
        // Datos de ejemplo para la tabla
        var datos = [{
                id: 1,
                nombre: 'Jose',
                apellido: 'Pérez',
                edad: 30
            },
            {
                id: 2,
                nombre: 'Diana',
                apellido: 'Gómez',
                edad: 25
            },
            {
                id: 3,
                nombre: 'Carlos',
                apellido: 'Rodríguez',
                edad: 1005
            }
        ];

        // Función para llenar la tabla con los datos
        function llenarTabla() {
            var tbody = $('#dynamicTable tbody');
            tbody.empty(); // Limpiamos el contenido actual de la tabla

            // Iteramos sobre los datos y creamos las filas de la tabla
            $.each(datos, function(index, item) {
                var fila = $('<tr>');
                fila.append('<th scope="row">' + item.id + '</th>');
                fila.append('<td>' + item.nombre + '</td>');
                fila.append('<td>' + item.apellido + '</td>');
                fila.append('<td>' + item.edad + '</td>');
                tbody.append(fila);
            });
        }

        // Llamamos a la función para llenar la tabla al cargar la página
        llenarTabla();
    });
</script>