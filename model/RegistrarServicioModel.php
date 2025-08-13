<?php
require_once __DIR__ . '/../config/database.php';

class RegistrarServicioModel
{
    private $conn;
    private $data = [];

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function setData($ruc, $razon_social, $nro_factura, $fecha_servicio, $nombre, $precio, $descripcion, $igv, $tipo, $descuento)
    {
        $this->data = compact('ruc', 'razon_social', 'nro_factura', 'fecha_servicio', 'nombre', 'precio', 'descripcion', 'igv', 'tipo', 'descuento');
    }

    public function registrar()
    {
        try {
            $sql = "INSERT INTO egresos_servicios 
                    (ruc, razon_social, nro_factura, fecha_servicio, nombre_servicio, tipo_servicio, precio_servicio, descripcion, igv, tipo, descuento)
                    VALUES (:ruc, :razon_social, :nro_factura, :fecha_servicio, :nombre, 'Servicio', :precio, :descripcion, :igv, :tipo, :descuento)";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':ruc' => $this->data['ruc'],
                ':razon_social' => $this->data['razon_social'],
                ':nro_factura' => $this->data['nro_factura'],
                ':fecha_servicio' => $this->data['fecha_servicio'],
                ':nombre' => $this->data['nombre'],
                ':precio' => $this->data['precio'],
                ':descripcion' => $this->data['descripcion'],
                ':igv' => $this->data['igv'],
                ':tipo' => $this->data['tipo'],
                ':descuento' => $this->data['descuento'],
            ]);
        } catch (PDOException $e) {
            echo "Error al registrar servicio: " . $e->getMessage();
            return false;
        }
    }
}
