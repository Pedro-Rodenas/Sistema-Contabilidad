<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Nuevo Egreso</title>
    <link rel="stylesheet" href="../assets/css/generales.css">
    <link rel="stylesheet" href="../assets/css/registrar_egreso.css">
</head>

<body>
    <header>
        <img src="../assets/img/logo.png" alt="">
        <a class="a-registrar-egreso" href="Registrar_Egreso.php">Registrar Egreso</a>
        <a href="Egresos.php">Egresos</a>
        <a href="Estadisticas.php">Estadísticas</a>
        <a href="Reporte.php">Reporte</a>
        <a href="loginAdmin.php">Admin</a>
        <p class="derecho_reservado">© 2025 Aprode Perú - Todos los derechos reservados</p>
    </header>
    <main>
        <section class="form-section">
            <h1>Registrar un Nuevo Egreso - Aprode Perú</h1>

            <div class="select-wrapper">
                <select id="tipo_egreso">
                    <option value="">Selecciona un tipo</option>
                    <option value="producto">Producto</option>
                    <option value="servicio">Servicio</option>
                    <option value="consumo">Consumo</option>
                </select>
            </div>


            <!-- PRODUCTOS -->
            <form id="form_producto" class="form-egreso" method="POST" action="../controller/RegistrarProductoController.php" style="display: none;">

                <div class="form-group doble">
                    <div>
                        <label for="ruc">RUC:</label>
                        <input type="text" name="ruc" required>
                    </div>
                    <div>
                        <label for="razon_social">Razón Social:</label>
                        <input type="text" name="razon_social" required>
                    </div>
                </div>

                <div class="form-group doble">
                    <div class="form-group">
                        <label for="Tipo">Tipo De Recibo</label>
                        <select class="select-serie" name="tipo" id="tipo">
                            <option value="Factura">Factura</option>
                            <option value="Boleta">Boleta</option>
                        </select>
                    </div>
                    <div>
                        <label for="nro_factura">N° Serie:</label>
                        <input type="text" name="nro_factura" required>
                    </div>
                    <div>
                        <label for="fecha_compra">Fecha de Compra:</label>
                        <input type="date" name="fecha_compra" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="name">Nombre del producto:</label>
                    <input type="text" name="name" required>
                </div>

                <div class="form-group doble">
                    <div>
                        <label for="cantidad">Cantidad:</label>
                        <input type="text" name="cantidad" required>
                    </div>
                    <div>
                        <label for="precio">Valor de Venta:</label>
                        <input type="number" step="0.01" name="precio" required>
                    </div>
                    <div>
                        <label for="precio">IGV (18%):</label>
                        <input type="number" step="0.01" name="igv" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="name">Descripción:</label>
                    <textarea name="descripcion" id="descripcion"></textarea>
                </div>

                <button type="submit">Registrar Producto</button>
            </form>

            <!-- SERVICIOS -->
            <form id="form_servicio" class="form-egreso" method="POST" action="../controller/RegistrarServicioController.php" style="display: none;">
                <div class="form-group doble">
                    <div class="form-group">
                        <label for="ruc">RUC:</label>
                        <input type="text" name="ruc" required>
                    </div>
                    <div class="form-group">
                        <label for="razon_social">Razón Social:</label>
                        <input type="text" name="razon_social" required>
                    </div>
                </div>
                <div class="form-group doble">
                    <div class="form-group">
                        <label for="Tipo">Tipo De Recibo</label>
                        <select class="select-serie" name="tipo" id="tipo">
                            <option value="Factura">Factura</option>
                            <option value="Boleta">Boleta</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nro_factura">N° Serie:</label>
                        <input type="text" name="nro_factura" required>
                    </div>
                    <div class="form-group">
                        <label for="fecha_servicio">Fecha del Servicio:</label>
                        <input type="date" name="fecha_servicio" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name">Nombre del Servicio:</label>
                    <input type="text" name="name" required>
                </div>
                <div class="form-group doble">
                    <div class="form-group">
                        <label for="periodo_consumo">Periodo de Consumo:</label>
                        <input type="text" name="periodo_consumo" required>
                    </div>
                    <div class="form-group">
                        <label for="precio">Valor de Servicio:</label>
                        <input type="number" step="0.01" name="precio" required>
                    </div>
                    <div>
                        <label for="precio">IGV (18%):</label>
                        <input type="number" step="0.01" name="igv" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="name">Descripción:</label>
                    <textarea name="descripcion" id="descripcion"></textarea>
                </div>

                <button type="submit">Registrar Servicio</button>
            </form>

            <!-- CONSUMOS -->
            <form id="form_consumo" class="form-egreso" method="POST" action="../controller/RegistrarConsumoController.php" style="display: none;">
                <div class="form-group doble">
                    <div class="form-group">
                        <label for="ruc">RUC:</label>
                        <input type="text" name="ruc" required>
                    </div>
                    <div class="form-group">
                        <label for="razon_social">Razón Social:</label>
                        <input type="text" name="razon_social" required>
                    </div>
                </div>
                <div class="form-group doble">
                    <div class="form-group">
                        <label for="Tipo">Tipo De Recibo</label>
                        <select class="select-serie" name="tipo" id="tipo">
                            <option value="Factura">Factura</option>
                            <option value="Boleta">Boleta</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nro_factura">N° Serie:</label>
                        <input type="text" name="nro_factura" required>
                    </div>
                    <div class="form-group">
                        <label for="fecha_servicio">Fecha del Consumo:</label>
                        <input type="date" name="fecha_servicio" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name">Nombre del Consumo:</label>
                    <input type="text" name="name" required>
                </div>
                <div class="form-group doble">
                    <div class="form-group">
                        <label for="periodo_consumo">Cantidad de Consumo:</label>
                        <input type="text" name="periodo_consumo" required>
                    </div>
                    <div class="form-group">
                        <label for="precio">Valor de Consumo:</label>
                        <input type="number" step="0.01" name="precio" required>
                    </div>
                    <div>
                        <label for="precio">IGV (18%):</label>
                        <input type="number" step="0.01" name="igv" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="name">Descripción:</label>
                    <textarea name="descripcion" id="descripcion"></textarea>
                </div>

                <button type="submit">Registrar Servicio</button>
            </form>

        </section>
    </main>
    <script src="../assets/js/mostrar_formulario.js"></script>
</body>

</html>