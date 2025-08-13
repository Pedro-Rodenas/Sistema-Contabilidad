<?php
require_once __DIR__ . '/../model/TablaEgresosModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $tipo = $_POST['tipo'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $igv = $_POST['igv'] ?? null;
    $adquisicion = $_POST['adquisicion'] ?? 0;
    $fecha = $_POST['fecha'] ?? null;
    $descuento = $_POST['descuento'] ?? 0;

    $model = new TablaEgresosModel();
    $resultado = false;

    if ($tipo === 'Producto') {
        $resultado = $model->editarProducto($id, $nombre, $precio, $igv, $fecha, $descuento);
    } elseif ($tipo === 'Servicio') {
        $resultado = $model->editarServicio($id, $nombre, $precio, $igv, $fecha, $descuento);
    } elseif ($tipo === 'Consumo') {
        $resultado = $model->editarConsumo($id, $nombre, $precio, $igv, $fecha, $descuento);
    } elseif ($tipo === 'Transferencia') {
        $resultado = $model->editarTransferencia($id, $nombre, $precio, $igv, $fecha, $descuento, $adquisicion);
    } else {
        http_response_code(400);
        echo "Tipo de egreso no válido.";
        exit;
    }

    if ($resultado) {
        echo "OK";
    } else {
        http_response_code(500);
        echo "Error al actualizar el egreso.";
    }
}
