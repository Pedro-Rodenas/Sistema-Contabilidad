<?php
require_once '../model/TablaEgresosModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $tipo = $_POST['tipo'] ?? null;

    if ($id && $tipo) {
        $modelo = new TablaEgresosModel();

        // Verifica si es un producto o servicio y llama al método adecuado
        if ($tipo === 'Producto') {
            $resultado = $modelo->eliminarProducto($id);
        } else if ($tipo === 'Servicio') {
            $resultado = $modelo->eliminarServicio($id);
        } else {
            echo "Tipo de egreso no válido.";
            exit;
        }

        echo $resultado ? "Egreso eliminado correctamente." : "Error al eliminar el egreso.";
    } else {
        echo "Datos incompletos.";
    }
}
