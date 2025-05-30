<?php
session_start();

if (!isset($_SESSION['usuario_id']) || !in_array($_SESSION['usuario_rol'], ['usuario', 'admin'])) {
    header('Location: ../index.php');
    exit;
}
?>

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
        <div class="logo-container">
            <img src="../assets/img/logo.png" alt="Logo Aprode Perú">
        </div>

        <nav class="nav-links">
            <a href="Registrar_Egreso.php">Registrar Egreso</a>
            <a href="Egresos.php">Egresos</a>
            <a href="Estadisticas.php">Estadísticas</a>
            <a href="Reporte.php">Reporte</a>
            <a href="usuarios.php">Administración</a>
        </nav>

        <div class="footer-section">
            <p class="derecho_reservado">© 2025 Aprode Perú<br>Todos los derechos reservados</p>
            <a class="logout-button" href="../controller/logout.php">Cerrar sesión</a>
        </div>
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

        <section class="c-graficos-1">
            <div class="grafico-lineas">
                <canvas id="graficoLineas" height="250"></canvas>
            </div>
            <div class="grafico-pastel">
                <h2>Productos y Servicios</h2>
                <canvas id="gráficoDonut"></canvas>
            </div>
        </section>

    </main>

    <script src="../assets/js/chart.min.js"></script>
    <script src="../assets/js/estadisticas.js"></script>
    <script src="../assets/js/chartjs-plugin-datalabels.min.js"></script>
</body>

</html>