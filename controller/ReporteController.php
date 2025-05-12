<?php

require_once __DIR__ . "/../model/ReporteModel.php";
require_once __DIR__ . "/../fpdf/fpdf.php";

class ReporteController
{
    private $model;

    public function __construct()
    {
        $this->model = new TablaEgresosModel();
    }

    public function generarReporte($anio, $mes)
    {
        // Llama al modelo para generar el reporte en PDF
        $this->model->exportarReportePDF($anio, $mes);
    }
}

if (isset($_GET['accion'])) {
    $accion = $_GET['accion'];
    $controller = new ReporteController();

    if ($accion === 'mes' && isset($_GET['ano']) && isset($_GET['mes'])) {
        $anio = $_GET['ano'];
        $mes = $_GET['mes'];
        $controller->generarReporte($anio, $mes);
    } elseif ($accion === 'ano' && isset($_GET['ano'])) {
        $anio = $_GET['ano'];
        // Para el año completo, pasa null como mes
        $controller->generarReporte($anio, null);
    } else {
        echo "Parámetros insuficientes para generar el reporte.";
    }
}
