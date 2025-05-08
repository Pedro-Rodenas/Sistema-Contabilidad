<?php
require_once __DIR__ . '/../config/database.php';

class RegistrarProductoModel
{
    private $conn;
    private $data = [];

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function setData($ruc, $razon_social, $nro_factura, $fecha_compra, $nombre, $cantidad, $precio, $descripcion)
    {
        $this->data = compact('ruc', 'razon_social', 'nro_factura', 'fecha_compra', 'nombre', 'cantidad', 'precio', 'descripcion');
    }

    public function registrar()
    {
        try {
            $sql = "INSERT INTO egresos_productos 
                    (ruc, razon_social, nro_factura, fecha_compra, nombre_producto, tipo_producto, cant_productos, precio_producto, descripcion)
                    VALUES (:ruc, :razon_social, :nro_factura, :fecha_compra, :nombre, 'Producto', :cantidad, :precio, :descripcion)";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':ruc' => $this->data['ruc'],
                ':razon_social' => $this->data['razon_social'],
                ':nro_factura' => $this->data['nro_factura'],
                ':fecha_compra' => $this->data['fecha_compra'],
                ':nombre' => $this->data['nombre'],
                ':cantidad' => $this->data['cantidad'],
                ':precio' => $this->data['precio'],
                ':descripcion' => $this->data['descripcion']
            ]);
        } catch (PDOException $e) {
            echo "Error al registrar producto: " . $e->getMessage();
            return false;
        }
    }
}
