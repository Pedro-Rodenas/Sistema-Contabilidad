<?php
require_once __DIR__ . '/../model/EstadisticasModel.php';

header('Content-Type: application/json');

$ano = isset($_GET['ano']) ? $_GET['ano'] : date('Y');

$model = new EstadisticasModel();

$mes_mas_gasto = $model->getMesMasGasto($ano);
$mes_menos_gasto = $model->getMesMenosGasto($ano);
$producto_mas_caro = $model->getProductoMasCaro($ano);
$egresos_por_mes = $model->getEgresosPorMes($ano);
$grafico_pastel = $model->getDistribucionEgresosPorTipo($ano);
$comparacion_anual = $model->getComparacionAnual($ano);

/* Devolvemos los daos en json */
echo json_encode([
    'mes_mas_gasto' => $mes_mas_gasto,
    'mes_menos_gasto' => $mes_menos_gasto,
    'producto_mas_caro' => $producto_mas_caro,
    'grafico_lineas' => $egresos_por_mes,
    'grafico_pastel'=> $grafico_pastel,
    'comparacion_anual' => $comparacion_anual
]);
