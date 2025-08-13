<?php
session_start();

if (!isset($_SESSION['usuario_id']) || !in_array($_SESSION['usuario_rol'], ['usuario', 'admin'])) {
    header('Location: ../index.php');
    exit;
}
?>

?>
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
        <section class="form-section">
            <h1>Registrar un Nuevo Egreso - Aprode Perú</h1>

            <div class="select-wrapper">
                <select id="tipo_egreso">
                    <option value="">Selecciona un tipo</option>
                    <option value="producto">Producto</option>
                    <option value="servicio">Servicio</option>
                    <option value="consumo">Consumo</option>
                    <option value="transferencia">Transferencia</option>
                </select>
            </div>


            <!-- PRODUCTOS -->
            <form id="form_producto" class="form-egreso" method="POST" action="../controller/RegistrarProductoController.php" style="display: none;">

                <div class="form-group doble">
                    <div class="form-group">
                        <label for="ruc">RUC:</label>
                        <input autocomplete="off" type="number" name="ruc" class="ruc-input" pattern="\d{11}" maxlength="11" required>
                        <div class="error-message ruc-error"></div>
                    </div>
                    <div class="form-group">
                        <label for="razon_social">Razón Social:</label>
                        <input autocomplete="off" type="text" name="razon_social" required>
                    </div>
                </div>

                <div class="form-group doble">
                    <div class="form-group">
                        <label for="Tipo">Tipo De Recibo</label>
                        <select class="select-serie" name="tipo" id="tipo">
                            <option value="Factura">Factura</option>
                            <option value="Boleta">Boleta</option>
                            <option value="Ticket">Ticket</option>
                            <option value="Recibi">Recibo</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nro_factura">N° Serie:</label>
                        <input autocomplete="off" type="text" name="nro_factura" required>
                    </div>
                    <div class="form-group">
                        <label for="fecha_compra">Fecha de Compra:</label>
                        <input autocomplete="off" type="date" name="fecha_compra" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="name">Nombre del producto:</label>
                    <input autocomplete="off" type="text" name="name" required>
                </div>

                <div class="form-group doble">
                    <div>
                        <label for="precio">Valor de Venta:</label>
                        <input autocomplete="off" type="number" step="0.01" name="precio" required>
                    </div>
                    <div>
                        <label for="precio">IGV (18%):</label>
                        <input autocomplete="off" type="number" step="0.01" name="igv" required>
                    </div>
                    <div>
                        <label for="descuento">Descuento:</label>
                        <input autocomplete="off" type="number" step="0.01" name="descuento">
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
                        <input autocomplete="off" type="number" name="ruc" class="ruc-input" pattern="\d{11}" maxlength="11" required>

                        <div class="error-message ruc-error"></div>
                    </div>
                    <div class="form-group">
                        <label for="razon_social">Razón Social:</label>
                        <input autocomplete="off" type="text" name="razon_social" required>
                    </div>
                </div>
                <div class="form-group doble">
                    <div class="form-group">
                        <label for="Tipo">Tipo De Recibo</label>
                        <select class="select-serie" name="tipo" id="tipo">
                            <option value="Factura">Factura</option>
                            <option value="Boleta">Boleta</option>
                            <option value="Recibi">Recibo</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nro_factura">N° Serie:</label>
                        <input autocomplete="off" type="text" name="nro_factura" required>
                    </div>
                    <div class="form-group">
                        <label for="fecha_servicio">Fecha del Servicio:</label>
                        <input autocomplete="off" type="date" name="fecha_servicio" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name">Nombre del Servicio:</label>
                    <input autocomplete="off" type="text" name="name" required>
                </div>
                <div class="form-group doble">
                    <div class="form-group">
                        <label for="precio">Valor de Servicio:</label>
                        <input type="number" step="0.01" name="precio" required>
                    </div>
                    <div>
                        <label for="precio">IGV (18%):</label>
                        <input autocomplete="off" type="number" step="0.01" name="igv" required>
                    </div>
                    <div>
                        <label for="descuento">Descuento:</label>
                        <input autocomplete="off" type="number" step="0.01" name="descuento">
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
                        <input autocomplete="off" type="number" name="ruc" class="ruc-input" pattern="\d{11}" maxlength="11" required>
                        <div class="error-message ruc-error"></div>
                    </div>
                    <div class="form-group">
                        <label for="razon_social">Razón Social:</label>
                        <input autocomplete="off" type="text" name="razon_social" required>
                    </div>
                </div>
                <div class="form-group doble">
                    <div class="form-group">
                        <label for="tipo">Tipo De Recibo:</label>
                        <select class="select-serie" name="tipo" id="tipo" required>
                            <option value="Factura">Factura</option>
                            <option value="Boleta">Boleta</option>
                            <option value="Recibo">Recibo</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nro_factura">N° Serie:</label>
                        <input autocomplete="off" type="text" name="nro_factura" required>
                    </div>
                    <div class="form-group">
                        <label for="fecha_consumo">Fecha del Consumo:</label>
                        <input autocomplete="off" type="date" name="fecha_consumo" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="nombre_consumo">Nombre del Consumo:</label>
                    <input autocomplete="off" type="text" name="nombre_consumo" required>
                </div>
                <div class="form-group doble">
                    <div class="form-group">
                        <label for="precio_consumo">Valor de Consumo:</label>
                        <input autocomplete="off" type="number" step="0.01" name="precio_consumo" required>
                    </div>
                    <div>
                        <label for="igv">IGV (18%):</label>
                        <input autocomplete="off" type="number" step="0.01" name="igv" required>
                    </div>
                    <div>
                        <label for="descuento">Descuento:</label>
                        <input autocomplete="off" type="number" step="0.01" name="descuento">
                    </div>
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción:</label>
                    <textarea name="descripcion" id="descripcion"></textarea>
                </div>

                <button type="submit">Registrar Consumo</button>
            </form>

            <!-- Transferencia -->
            <form id="form_transferencia" class="form-egreso" method="POST" action="../controller/RegistrarTransferenciaController.php" style="display: none;">
                <div class="form-group doble">
                    <div class="form-group">
                        <label for="ruc">RUC/DNI:</label>
                        <input autocomplete="off" type="text" name="ruc" required>
                    </div>
                    <div class="form-group">
                        <label for="razon_social">Razón Social:</label>
                        <input autocomplete="off" type="text" name="razon_social" required>
                    </div>
                </div>
                <div class="form-group doble">
                    <div class="form-group">
                        <label for="tipo">Tipo De Recibo:</label>
                        <select class="select-serie" name="tipo" id="tipo" required>
                            <option value="Constancia">Constancia</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nro_factura">N° Constancia:</label>
                        <input autocomplete="off" type="text" name="nro_factura" required>
                    </div>
                    <div class="form-group">
                        <label for="fecha_transferencia">Fecha del Transferencia:</label>
                        <input autocomplete="off" type="date" name="fecha_transferencia" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="datalle_transferencia">Detalle de Transferencia:</label>
                    <input autocomplete="off" type="text" name="detalle_transferencia" required>
                </div>
                <div class="form-group doble">
                    <div class="form-group">
                        <label for="monto_transferencia">Valor de Transferencia:</label>
                        <input autocomplete="off" type="number" step="0.01" name="monto_transferencia" required>
                    </div>
                    <div class="form-group">
                        <label for="adquisicion">Adquisición / Comisión:</label>
                        <input autocomplete="off" type="number" step="0.01" name="adquisicion" value="0.00" required>
                    </div>
                </div>

                <button type="submit">Registrar Consumo</button>
            </form>

        </section>
    </main>
    <script src="../assets/js/mostrar_formulario.js"></script>
    <script src="../assets/js/validaciones_registro.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const registro = urlParams.get('registro');

        if (registro === 'exito') {
            Swal.fire({
                icon: 'success',
                title: 'Registrado',
                text: 'El egreso fue registrado exitosamente.',
                confirmButtonText: 'Aceptar'
            });
        } else if (registro === 'error') {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ocurrió un error al registrar el egreso.',
                confirmButtonText: 'Aceptar'
            });
        }
    </script>
</body>

</html>