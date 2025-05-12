<?php
require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . '/../fpdf/fpdf.php'; // Agregar FPDF

class TablaEgresosModel
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function obtenerEgresosPorMes($anio, $mes)
    {
        $egresos = [];

        // Productos
        $queryProductos = "
            SELECT 
                id_producto AS id,
                fecha_compra AS fecha,
                'Producto' AS tipo_egreso,
                nombre_producto AS nombre,
                cant_productos AS cantidad,
                precio_producto AS precio,
                igv,
                tipo AS tipo_factura,
                descripcion,
                ruc,
                razon_social,
                nro_factura,
                tipo_producto AS tipo_origen,
                estado
            FROM egresos_productos
            WHERE YEAR(fecha_compra) = :anio
            AND (:mes IS NULL OR MONTH(fecha_compra) = :mes)
        ";

        $stmtProductos = $this->conn->prepare($queryProductos);
        $stmtProductos->bindParam(':anio', $anio, PDO::PARAM_INT);
        $stmtProductos->bindParam(':mes', $mes, PDO::PARAM_INT);
        $stmtProductos->execute();

        $egresos = array_merge($egresos, $stmtProductos->fetchAll(PDO::FETCH_ASSOC));

        // Servicios
        $queryServicios = "
            SELECT 
                id_servicio AS id,
                fecha_servicio AS fecha,
                'Servicio' AS tipo_egreso,
                nombre_servicio AS nombre,
                periodo_consumo AS cantidad,
                precio_servicio AS precio,
                igv,
                tipo AS tipo_factura,
                descripcion,
                ruc,
                razon_social,
                nro_factura,
                tipo_servicio AS tipo_origen,
                estado
            FROM egresos_servicios
            WHERE YEAR(fecha_servicio) = :anio AND MONTH(fecha_servicio) = :mes
        ";

        $stmtServicios = $this->conn->prepare($queryServicios);
        $stmtServicios->bindParam(':anio', $anio, PDO::PARAM_INT);
        $stmtServicios->bindParam(':mes', $mes, PDO::PARAM_INT);
        $stmtServicios->execute();

        $egresos = array_merge($egresos, $stmtServicios->fetchAll(PDO::FETCH_ASSOC));

        // Consumptions
        $queryConsumptions = "
            SELECT 
                id_consumo AS id,
                fecha_consumo AS fecha,
                'Consumo' AS tipo_egreso,
                nombre_consumo AS nombre,
                cant_consumo AS cantidad,
                precio_consumo AS precio,
                igv,
                tipo AS tipo_factura,
                descripcion,
                ruc,
                razon_social,
                nro_factura,
                tipo_consumo AS tipo_origen,
                estado
            FROM egresos_consumo
            WHERE YEAR(fecha_consumo) = :anio AND MONTH(fecha_consumo) = :mes
        ";

        $stmtConsumptions = $this->conn->prepare($queryConsumptions);
        $stmtConsumptions->bindParam(':anio', $anio, PDO::PARAM_INT);
        $stmtConsumptions->bindParam(':mes', $mes, PDO::PARAM_INT);
        $stmtConsumptions->execute();

        $egresos = array_merge($egresos, $stmtConsumptions->fetchAll(PDO::FETCH_ASSOC));

        return $egresos;
    }

    public function exportarReportePDF($anio, $mes)
    {
        require_once __DIR__ . '/../fpdf/fpdf.php';

        // Obtención de los egresos
        $egresos = $this->obtenerEgresosPorMes($anio, $mes);

        $pdf = new FPDF();
        $pdf->AddPage();

        // Logo en la esquina superior derecha
        $logoPath = __DIR__ . '/../assets/img/logo.png';
        if (file_exists($logoPath)) {
            $pdf->Image($logoPath, 170, 10, 30); // Posición derecha
        }

        // Título centrado
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Reporte de Egresos', 0, 1, 'C');

        $pdf->Ln(20); // Espacio debajo del título

        // Función para imprimir la cabecera de la tabla
        $imprimirEncabezado = function ($pdf) {
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(10, 8, 'ID', 1, 0, 'C');
            $pdf->Cell(25, 8, 'Fecha', 1, 0, 'C');
            $pdf->Cell(25, 8, 'Tipo', 1, 0, 'C');
            $pdf->Cell(40, 8, 'Nombre', 1, 0, 'C');
            $pdf->Cell(15, 8, 'Cant.', 1, 0, 'C');
            $pdf->Cell(20, 8, 'Precio', 1, 0, 'C');
            $pdf->Cell(20, 8, 'IGV', 1, 0, 'C');
            $pdf->Cell(35, 8, 'Factura', 1, 1, 'C');
        };

        // Imprimir la cabecera por primera vez
        $imprimirEncabezado($pdf);

        $pdf->SetFont('Arial', '', 9);

        // Altura máxima antes de saltar página
        $limiteAltura = 270;
        $alturaFila = 8;

        foreach ($egresos as $e) {
            // Si nos pasamos del límite, nueva página y reimprimir encabezado
            if ($pdf->GetY() + $alturaFila > $limiteAltura) {
                $pdf->AddPage();
                if (file_exists($logoPath)) {
                    $pdf->Image($logoPath, 170, 10, 30);
                }
                $pdf->SetFont('Arial', 'B', 16);
                $pdf->Cell(0, 10, 'Reporte de Egresos (continuación)', 0, 1, 'C');
                $pdf->Ln(20);
                $imprimirEncabezado($pdf);
                $pdf->SetFont('Arial', '', 9);
            }

            $pdf->Cell(10, 8, $e['id'], 1, 0, 'C');
            $pdf->Cell(25, 8, $e['fecha'], 1, 0, 'C');
            $pdf->Cell(25, 8, $e['tipo_egreso'], 1, 0, 'C');
            $pdf->Cell(40, 8, substr($e['nombre'], 0, 20), 1, 0, 'C');
            $pdf->Cell(15, 8, $e['cantidad'], 1, 0, 'C');
            $pdf->Cell(20, 8, $e['precio'], 1, 0, 'C');
            $pdf->Cell(20, 8, $e['igv'], 1, 0, 'C');
            $pdf->Cell(35, 8, $e['nro_factura'], 1, 1, 'C');
        }

        // Descargar el PDF
        $pdf->Output('D', "reporte_{$mes}_{$anio}.pdf");
    }
}
