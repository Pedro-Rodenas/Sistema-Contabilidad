<?php
require_once __DIR__ . '/../config/database.php';

class RegistrarConsumoModel
{
    private $conn;
    private $data = [];

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function setData($ruc, $razon_social, $nro_factura, $fecha_consumo, $nombre, $cantidad, $precio, $descripcion, $igv, $tipo)
    {
        // Guardamos los datos en el array
        $this->data = compact('ruc', 'razon_social', 'nro_factura', 'fecha_consumo', 'nombre', 'cantidad', 'precio', 'descripcion', 'igv', 'tipo');
    }

    public function registrar()
    {
        try {
            // La consulta SQL para insertar los datos en la tabla egresos_consumo
            $sql = "INSERT INTO egresos_consumo 
                    (`ruc`, `razon_social`, `nro_factura`, `fecha_consumo`, `nombre_consumo`, `tipo_consumo`, `cant_consumo`, `precio_consumo`, `descripcion`, `igv`, `tipo`)
                    VALUES (:ruc, :razon_social, :nro_factura, :fecha_consumo, :nombre, 'Consumo', :cantidad, :precio, :descripcion, :igv, :tipo)";

            // Preparamos la consulta SQL
            $stmt = $this->conn->prepare($sql);

            // Ejecutamos la consulta pasando los valores
            return $stmt->execute([ 
                ':ruc' => $this->data['ruc'],
                ':razon_social' => $this->data['razon_social'],
                ':nro_factura' => $this->data['nro_factura'],
                ':fecha_consumo' => $this->data['fecha_consumo'],
                ':nombre' => $this->data['nombre'],
                ':cantidad' => $this->data['cantidad'],
                ':precio' => $this->data['precio'],
                ':descripcion' => $this->data['descripcion'],
                ':igv' => $this->data['igv'],
                ':tipo' => $this->data['tipo']
            ]);
        } catch (PDOException $e) {
            // Si ocurre un error, mostramos el mensaje
            echo "Error al registrar consumo: " . $e->getMessage();
            return false;
        }
    }
}
