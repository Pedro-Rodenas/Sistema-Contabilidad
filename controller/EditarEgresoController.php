<?php
require_once __DIR__ . '/../model/TablaEgresosModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $tipo = $_POST['tipo'];
    $nombre = $_POST['nombre'];
    $cantidad = $_POST['cantidad'];
    $precio = $_POST['precio'];

    $model = new TablaEgresosModel();

    $resultado = false;

    if ($tipo === 'Producto') {
        $resultado = $model->editarProducto($id, $nombre, $cantidad, $precio);
    } elseif ($tipo === 'Servicio') {
        $resultado = $model->editarServicio($id, $nombre, $cantidad, $precio);
    } else {
        http_response_code(400);
        echo "Tipo de egreso no válido.";
        exit;
    }
}
