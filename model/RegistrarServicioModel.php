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

    public function setData($ruc, $razon_social, $nro_factura, $fecha_servicio, $nombre, $periodo, $precio, $descripcion)
    {
        $this->data = compact('ruc', 'razon_social', 'nro_factura', 'fecha_servicio', 'nombre', 'periodo', 'precio', 'descripcion');
    }

    public function registrar()
    {
        try {
            $sql = "INSERT INTO egresos_servicios 
                    (ruc, razon_social, nro_factura, fecha_servicio, nombre_servicio, tipo_servicio, periodo_consumo, precio_servicio, descripcion)
                    VALUES (:ruc, :razon_social, :nro_factura, :fecha_servicio, :nombre, 'Servicio', :periodo, :precio, :descripcion)";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':ruc' => $this->data['ruc'],
                ':razon_social' => $this->data['razon_social'],
                ':nro_factura' => $this->data['nro_factura'],
                ':fecha_servicio' => $this->data['fecha_servicio'],
                ':nombre' => $this->data['nombre'],
                ':periodo' => $this->data['periodo'],
                ':precio' => $this->data['precio'],
                ':descripcion' => $this->data['descripcion']
            ]);
        } catch (PDOException $e) {
            echo "Error al registrar servicio: " . $e->getMessage();
            return false;
        }
    }
}
