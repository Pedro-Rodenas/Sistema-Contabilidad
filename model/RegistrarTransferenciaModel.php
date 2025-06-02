<?php
require_once __DIR__ . '/../config/database.php';

class RegistrarTransferenciaModel
{
    private $conn;
    private $data = [];

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function setData($dni_transferencia, $razon_social, $nro_factura, $fecha_transferencia, $detalle_transferencia, $monto_transferencia, $tipo)
    {
        $this->data = compact('dni_transferencia', 'razon_social', 'nro_factura', 'fecha_transferencia', 'detalle_transferencia', 'monto_transferencia', 'tipo');
    }

    public function registrar()
    {
        try {
            $sql = "INSERT INTO egresos_transferencia
                (dni_transferencia, razon_social, nro_factura, fecha_transferencia, detalle_transferencia, tipo_transferencia, monto_transferencia, tipo)
                VALUES (:dni_transferencia, :razon_social, :nro_factura, :fecha_transferencia, :detalle_transferencia, 'transferencia', :monto_transferencia, :tipo)";

            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':dni_transferencia' => $this->data['dni_transferencia'],
                ':razon_social' => $this->data['razon_social'],
                ':nro_factura' => $this->data['nro_factura'],
                ':fecha_transferencia' => $this->data['fecha_transferencia'],
                ':detalle_transferencia' => $this->data['detalle_transferencia'],
                ':monto_transferencia' => $this->data['monto_transferencia'],
                ':tipo' => $this->data['tipo']
            ]);
        } catch (PDOException $e) {
            echo "Error al registrar transferencia: " . $e->getMessage();
            return false;
        }
    }
}
