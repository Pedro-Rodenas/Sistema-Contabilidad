<?php
require_once __DIR__ . '/../model/RegistrarServicioModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new RegistrarServicioController();
    $controller->registrar();
}

class RegistrarServicioController
{
    public function registrar()
    {
        $ruc = $_POST['ruc'];
        $razon_social = $_POST['razon_social'];
        $nro_factura = $_POST['nro_factura'];
        $fecha_servicio = $_POST['fecha_servicio'];
        $nombre = $_POST['name'];
        $precio = $_POST['precio'];
        $descripcion = $_POST['descripcion'];
        $igv = $_POST['igv'];
        $tipo = $_POST['tipo'];

        $model = new RegistrarServicioModel();
        $model->setData($ruc, $razon_social, $nro_factura, $fecha_servicio, $nombre, $precio, $descripcion, $igv, $tipo);

        if ($model->registrar()) {
            header('Location: ../view/Registrar_Egreso.php?registro=exito');
        } else {
            header('Location: ../view/Registrar_Egreso.php?registro=error');
        }
    }
}
