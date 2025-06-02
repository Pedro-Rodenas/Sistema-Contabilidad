<?php
require_once __DIR__ . '/../model/RegistrarTransferenciaModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new RegistrarTransferenciaController();
    $controller->registrar();
}

class RegistrarTransferenciaController
{
    public function registrar()
    {
        $dni_transferencia = $_POST['ruc']; 
        $razon_social = $_POST['razon_social'];
        $nro_factura = $_POST['nro_factura'];
        $fecha_transferencia = $_POST['fecha_transferencia'];
        $detalle_transferencia = $_POST['detalle_transferencia']; 
        $monto_transferencia = $_POST['monto_transferencia'];
        $tipo = $_POST['tipo'];

        $model = new RegistrarTransferenciaModel();
        $model->setData(
            $dni_transferencia,
            $razon_social,
            $nro_factura,
            $fecha_transferencia,
            $detalle_transferencia,
            $monto_transferencia,
            $tipo
        );

        if ($model->registrar()) {
            header('Location: ../view/Registrar_Egreso.php?registro=exito');
        } else {
            header('Location: ../view/Registrar_Egreso.php?registro=error');
        }
    }
}
