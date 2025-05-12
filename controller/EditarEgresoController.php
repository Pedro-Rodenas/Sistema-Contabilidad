<?php
require_once __DIR__ . '/../model/TablaEgresosModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $tipo = $_POST['tipo'];
    $nombre = $_POST['nombre'];
    $cantidad = $_POST['cantidad'];
    $precio = $_POST['precio'];
    $igv = $_POST['igv'];

    $model = new TablaEgresosModel();

    $resultado = false;

    if ($tipo === 'Producto') {
        $resultado = $model->editarProducto($id, $nombre, $cantidad, $precio, $igv);
    } elseif ($tipo === 'Servicio') {
        $resultado = $model->editarServicio($id, $nombre, $cantidad, $precio, $igv);
    } elseif ($tipo === 'Consumo') {
        $resultado = $model->editarConsumo($id, $nombre, $cantidad, $precio, $igv);
    } else {
        http_response_code(400);
        echo "Tipo de egreso no válido.";
        exit;
    }
}
