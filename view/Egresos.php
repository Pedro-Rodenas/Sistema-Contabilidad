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
    <title>Tabla de Egresos</title>
    <link rel="stylesheet" href="../assets/css/generales.css">
    <link rel="stylesheet" href="../assets/css/tabla_egresos.css">
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
        <section class="contenedor-tabla">
            <h1>Egresos de la ONG - Por Mes</h1>

            <fieldset class="c-filtros">
                <legend>Filtros</legend>
                <label for="year">Año:</label>
                <select name="year" id="year">
                    <option value="2025">2025</option>
                    <option value="2024">2024</option>
                    <option value="2023">2023</option>
                </select>

                <label for="month">Mes:</label>
                <select id="month" name="month">
                    <option value="1">Enero</option>
                    <option value="2">Febrero</option>
                    <option value="3">Marzo</option>
                    <option value="4">Abril</option>
                    <option value="5">Mayo</option>
                    <option value="6">Junio</option>
                    <option value="7">Julio</option>
                    <option value="8">Agosto</option>
                    <option value="9">Septiembre</option>
                    <option value="10">Octubre</option>
                    <option value="11">Noviembre</option>
                    <option value="12">Diciembre</option>
                </select>
            </fieldset>

            <div class="tabla-scroll">
                <table>
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Comprobante</th>
                            <th>Tipo de Egreso</th>
                            <th>Nombre</th>
                            <th>Base imponible</th>
                            <th>IGV (18%)</th>
                            <th>Descuento</th>
                            <th>Adquisición (Comisión)</th>
                            <th>Total</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-body">
                        <!-- Datos dinámicos -->
                    </tbody>
                </table>
            </div>

            <div class="totales-egresos">
                <p><strong>Total sin IGV:</strong> <span id="total-precio">S/. 0.00</span></p>
                <p><strong>Total IGV:</strong> <span id="total-igv">S/. 0.00</span></p>
                <p><strong>Total con IGV:</strong> <span id="total-con-igv">S/. 0.00</span></p>
            </div>
        </section>

        <!-- Modal -->
        <section id="modal" class="modal" style="display: none;">
            <form class="modal-content" id="form-editar">
                <h2>Editar Egreso</h2>
                <input type="hidden" id="editar-id" name="id">
                <input type="hidden" id="editar-origen" name="tipo">

                <label for="editar-nombre">Nombre:</label>
                <input type="text" id="editar-nombre" name="nombre">

                <label for="editar-precio">Base Imponible:</label>
                <input type="text" id="editar-precio" name="precio">

                <label for="editar-igv">IGV:</label>
                <input type="text" id="editar-igv" name="igv">

                <label for="editar-adquisicion">Adquisicion:</label>
                <input type="number" step="0.01" id="editar-adquisicion" name="adquisicion">

                <div class="modal-actions">
                    <button type="submit" class="btn-guardar">Guardar</button>
                    <button type="button" onclick="cerrarModal()" class="btn-cancelar">Cancelar</button>
                </div>
            </form>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../assets/js/tabla-egresos.js"></script>

</body>

</html>