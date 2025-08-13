<?php
require_once __DIR__ . '/../model/RegistrarConsumoModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new RegistrarConsumoController();
    $controller->registrar();
}

class RegistrarConsumoController
{
    public function registrar()
    {

        $ruc = $_POST['ruc'];
        $razon_social = $_POST['razon_social'];
        $nro_factura = $_POST['nro_factura'];
        $fecha_consumo = $_POST['fecha_consumo'];
        $nombre = $_POST['nombre_consumo'];
        $precio = $_POST['precio_consumo'];
        $descripcion = $_POST['descripcion'];
        $igv = $_POST['igv'];
        $tipo = $_POST['tipo'];
        $descuento = $_POST['descuento'];


        $model = new RegistrarConsumoModel();


        $model->setData($ruc, $razon_social, $nro_factura, $fecha_consumo, $nombre, $precio, $descripcion, $igv, $tipo, $descuento);


        if ($model->registrar()) {

            header('Location: ../view/Registrar_Egreso.php');
        } else {

            echo "Error al registrar consumo.";
        }
    }
}
