<?php
session_start();

if (!isset($_SESSION['usuario_id']) || !in_array($_SESSION['usuario_rol'], ['usuario', 'admin'])) {
    header('Location: ../index.php');
    exit;
}
?>

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Egresos</title>
    <link rel="stylesheet" href="../assets/css/generales.css">
    <link rel="stylesheet" href="../assets/css/reporte.css">
</head>

<body>
    <header>
        <img src="../assets/img/logo.png" alt="">
        <a href="Registrar_Egreso.php">Registrar Egreso</a>
        <a href="Egresos.php">Egresos</a>
        <a href="Estadisticas.php">Estadísticas</a>
        <a class="a-reporte" href="Reporte.php">Reporte</a>
        <a href="usuarios.php">Admin</a>
        <p class="derecho_reservado">© 2025 Aprode Perú - Todos los derechos reservados</p>
        <a href="../controller/logout.php">Cerrar sesión</a>
    </header>
    <main>
        <form id="form-reporte" onsubmit="return false;">
            <fieldset>
                <label for="mes">Mes:</label>
                <select id="mes" name="mes">
                    <option value="01">Enero</option>
                    <option value="02">Febrero</option>
                    <option value="03">Marzo</option>
                    <option value="04">Abril</option>
                    <option value="05">Mayo</option>
                    <option value="06">Junio</option>
                    <option value="07">Julio</option>
                    <option value="08">Agosto</option>
                    <option value="09">Septiembre</option>
                    <option value="10">Octubre</option>
                    <option value="11">Noviembre</option>
                    <option value="12">Diciembre</option>
                </select>

                <label for="ano">Año:</label>
                <select id="ano" name="ano">
                    <!-- Puedes llenarlo dinámicamente con años disponibles -->
                    <option value="2025">2025</option>
                    <option value="2024">2024</option>
                    <option value="2023">2023</option>
                    <!-- Agrega más años según sea necesario -->
                </select>
                <button id="sacar-reporte-mes">Sacar reporte por mes</button>
                <button id="sacar-reporte-ano">Sacar reporte del año</button>
            </fieldset>
        </form>
    </main>

    <script src="../assets//js/reporte.js"></script>
</body>

</html>