<?php
require_once __DIR__ . '/../model/RegistrarProductoModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new RegistrarProductoController();
    $controller->registrar();
}

class RegistrarProductoController
{
    public function registrar()
    {
        $ruc = $_POST['ruc'];
        $razon_social = $_POST['razon_social'];
        $nro_factura = $_POST['nro_factura'];
        $fecha_compra = $_POST['fecha_compra'];
        $nombre = $_POST['name'];
        $cantidad = $_POST['cantidad'];
        $precio = $_POST['precio'];
        $descripcion = $_POST['descripcion'];
        $igv = $_POST['igv'];
        $tipo = $_POST['tipo'];

        $model = new RegistrarProductoModel();
        $model->setData($ruc, $razon_social, $nro_factura, $fecha_compra, $nombre, $cantidad, $precio, $descripcion, $igv, $tipo);

        if ($model->registrar()) {
            header('Location: ../view/Registrar_Egreso.php');
        } else {
            echo "Error al registrar producto.";
        }
    }
}
