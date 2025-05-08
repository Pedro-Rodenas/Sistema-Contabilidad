<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadísticas de Egresos</title>
    <link rel="stylesheet" href="../assets/css/generales.css">
    <link rel="stylesheet" href="../assets/css/estadisticas.css">
</head>

<body>
    <header>
        <img src="../assets/img/logo.png" alt="">
        <a href="Registrar_Egreso.php">Registrar Egreso</a>
        <a href="Egresos.php">Egresos</a>
        <a class="a-estadisticas" href="Estadisticas.php">Estadísticas</a>
        <a href="Reporte.php">Reporte</a>
        <p class="derecho_reservado">© 2025 Aprode Perú - Todos los derechos reservados</p>
    </header>
    <main>
        <h1>Estadísticas de Egresos - Aprode Perú</h1>

        <!-- Filtro por año -->
        <label for="ano">Seleccionar Año:</label>
        <select id="ano" onchange="cargarEstadisticas()">
            <option value="2025">2025</option>
            <option value="2024">2024</option>
            <option value="2023">2023</option>
        </select>

        <div class="estadisticas-container">
            <div class="tarjeta-estadistica">
                <div class="titulo">Mes con más gasto</div>
                <div class="dato" id="mes-mas-gasto">Cargando...</div>
            </div>
            <div class="tarjeta-estadistica">
                <div class="titulo">Producto más costoso</div>
                <div class="dato" id="producto-mas-caro">Cargando...</div>
            </div>
            <div class="tarjeta-estadistica">
                <div class="titulo">Mes con menos gasto</div>
                <div class="dato" id="mes-menos-gasto">Cargando...</div>
            </div>
        </div>

        <h2 class="titulo-grafico">Egresos Mensuales</h2>
        <section class="c-graficos-1">
            <div class="grafico-lineas">
                <canvas id="graficoLineas" height="250"></canvas>
            </div>
            <section class="sub-graficos">
                <div class="grafico-pastel">
                    <h2>Productos y Servicios</h2>
                    <canvas id="graficoPastel"></canvas>
                </div>
                <div class="grafico-pastel">
                    <h2>Comparación Año Pasado</h2>
                    <canvas id="gráficoDonut"></canvas>
                </div>
                <div class="grafico-pastel">
                    <canvas id="grafico3"></canvas>
                </div>
            </section>
        </section>

    </main>

    <script src="../assets/js/chart.min.js"></script>
    <script src="../assets/js/estadisticas.js"></script>
    <script src="../assets/js/chartjs-plugin-datalabels.min.js"></script>
</body>

</html>