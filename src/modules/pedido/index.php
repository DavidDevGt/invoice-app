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
            <div class="col-3 mt-2 pt-3 text-center"></div>
            <div class="col-6 mt-2 pt-3 text-end">
                <!-- Area para botones en la parte de arriba -->
                <button class="btn btn-primary">
                    Nuevo Pedido
                </button>
                <button class="btn btn-dark">
                    Mandar a Transito
                </button>
                <button class="btn btn-danger">
                    Eliminar Pedido
                </button>
            </div>
        </div>
    </div>


    <!-- Contenido específico del módulo -->
    <div class="p-4 m-4 bg-white rounded">
        <div class="row">
            <div class="col-12">
                <h1>Pedido No. 2501</h1>
                <p>Factura emitida el 14/01/2024 a las 00:09:00</p>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-2"></div>
            <div class="col-2">
                <label for="pedido" class="form-label">No. Pedido</label>
                <input type="text" class="form-control" id="pedido">
            </div>
            <div class="col-2">
                <label for="nit" class="form-label">NIT Cliente</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="nit">
                    <span class="input-group-text bg-dark"><i class="fas fa-search text-white"></i></span>
                </div>
            </div>
            <div class="col-2">
                <label for="fecha" class="form-label">Fecha Pedido</label>
                <input type="text" class="form-control" id="fecha">
            </div>
            <div class="col-2">
                <label for="pago" class="form-label">Forma de Pago</label>
                <input type="text" class="form-control" id="pago">
            </div>
            <div class="col-2"></div>
        </div>
    </div>

    <div class="p-4 m-4 bg-white rounded">
        <div class="row">
            <div class="col-12">
                <?php require_once './../../components/shared/breadcrumb.php'; ?>
                <table class="table table-bordered">
                    <thead class="table-secondary">
                        <tr>
                            <th style="width: 8%;">Cantidad</th>
                            <th class="text-center" style="width: 8%;">Código</th>
                            <th style="width: 35%;">Nombre</th>
                            <th style="width: 10%;">Marca</th>
                            <th style="width: 10%;">Precio Unitario</th>
                            <th style="width: 10%;">Subtotal</th>
                            <th class="text-center" style="width: 10%;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="orderTableBody">
                        <!-- Filas de productos añadidas aquí -->
                        <tr>
                            <td>
                                <input type="text" class="form-control" id="cantidad">
                            </td>
                            <td class="text-center">123</td>
                            <td>Producto A</td>
                            <td>Marca X</td>
                            <td>Q 50.00</td>
                            <td>Q 100.00</td>
                            <td class="text-center">
                                <button class="btn btn-success"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <!-- Agregar más filas según sea necesario -->
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5" style="text-align:right;">Subtotal:</th>
                            <th id="subtotalSum">Q 0.00</th>
                            <th></th>
                        </tr>
                        <tr>
                            <th colspan="5" style="text-align:right;">Total:</th>
                            <th id="totalSum">Q 0.00</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
                <button id="addProductBtn" class="btn btn-success"><i class="fas fa-plus"></i> Añadir Producto</button>
            </div>
        </div>
    </div>

</body>

<?php

//** FOOTER *//
require_once './../../components/footer/default.php';

?>