<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . "/../model/TablaEgresosModel.php";



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $anio = $_POST['year'] ?? null;
    $mes = $_POST['mes'] ?? null;

    if ($anio && $mes) {
        try {
            $model = new TablaEgresosModel();
            $egresos = $model->obtenerEgresosPorMes($anio, $mes);
            header('Content-Type: application/json');
            echo json_encode($egresos);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error interno: ' . $e->getMessage()]);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Parámetros inválidos']);
    }
}
