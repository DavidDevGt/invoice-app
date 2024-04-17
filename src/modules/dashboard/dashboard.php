<?php

//** HEADER *//
require_once './../../components/header/default.php';

?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<body class="bg-body-secondary">

    <?php require_once './../../components/shared/navbar.php'; ?>


    <div class="row mt-3 m-4">
        <div class="col-4 mt-2 pt-3">
            <!-- Breadcrumb -->
            <?php require_once './../../components/shared/breadcrumb.php'; ?>
        </div>
        <div class="col-6 mt-2 pt-3 text-center"></div>
        <div class="col-2 mt-2 pt-3 text-end">
            <!-- Botones en la parte de arriba, si son necesarios -->
        </div>
    </div>
    <!-- Contenido específico del módulo -->
    <div class="p-4 m-4 bg-white rounded shadow">
        <h3 class="mt-3">Hola, <span id="nombre_usuario"></span></h3>
        <h6 class="text-muted mt-2">Te damos la bienvenida al sistema.</h6>

        <div class="mt-3">
            <button id="weekBtn" class="btn m-2 btn-success">Esta semana</button>
            <button id="monthBtn" class="btn m-2 btn-primary">Este mes</button>
            <button id="yearBtn" class="btn m-2 btn-dark">Este año</button>
        </div>

        <div class="row mt-3 text-center">
            <div class="col-lg-6 mt-3">
                <div class="card">
                    <div class="card-body">
                        <i class="fas fa-wallet fa-2x text-dark"></i>
                        <h5 class="card-title mt-2">Total Facturado</h5>
                        <p class="card-text display-4">Q 0.00</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mt-3">
                <div class="card">
                    <div class="card-body">
                        <i class="fas fa-file-invoice fa-2x text-dark"></i>
                        <h5 class="card-title mt-2">Total DTEs</h5>
                        <p class="card-text display-4">0</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col m-5">
                <canvas id="billingChart"></canvas>
            </div>
        </div>
    </div>


    <?php

    //** FOOTER *//
    require_once './../../components/footer/default.php';

    ?>

    <script>
        const username = localStorage.getItem('username');
        document.getElementById('nombre_usuario').textContent = username;
        
        let weeklyLabels = ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sáb'];
        let monthlyLabels = ['Sem 1', 'Sem 2', 'Sem 3', 'Sem 4'];
        let yearlyLabels = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];

        let weeklyData = [1000, 2000.5, 1200.3, 1500, 800, 450, 1250];
        let monthlyData = [10000, 22500.25, 31000.15, 15000.45];
        let yearlyData = [71000, 51000, 90500, 155200.50, 110205.25, 78500.85, 53505.50, 85800.50, 65000, 43505.40, 75000, 90350.25];

        function updateTotals(data) {
            let totalFacturado = data.reduce((acc, curr) => acc + curr, 0);

            let formattedTotal = currency(totalFacturado, {
                symbol: 'Q',
                precision: 2
            }).format();

            document.querySelector('.card-text.display-4').textContent = formattedTotal;
            document.querySelectorAll('.card-text.display-4')[1].textContent = data.length;
        }

        let ctx = document.getElementById('billingChart').getContext('2d');
        let billingChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: weeklyLabels,
                datasets: [{
                    label: 'Facturación de la semana',
                    data: weeklyData,
                    backgroundColor: 'rgba(0, 123, 255, 0.2)',
                    borderColor: 'rgba(0, 123, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });


        updateTotals(weeklyData);

        $('#weekBtn').click(function() {
            updateChartData(billingChart, weeklyData, 'Facturación de la semana', weeklyLabels);
            updateTotals(weeklyData);
        });

        $('#monthBtn').click(function() {
            updateChartData(billingChart, monthlyData, 'Facturación del mes', monthlyLabels);
            updateTotals(monthlyData);
        });

        $('#yearBtn').click(function() {
            updateChartData(billingChart, yearlyData, 'Facturación del año', yearlyLabels);
            updateTotals(yearlyData);
        });

        function updateChartData(chart, newData, newLabel, newLabels) {
            chart.data.datasets[0].data = newData;
            chart.data.datasets[0].label = newLabel;
            chart.data.labels = newLabels;
            chart.update();
        }
    </script>
</body>