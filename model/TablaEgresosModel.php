<?php
require_once __DIR__ . "/../config/database.php";
class TablaEgresosModel
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function obtenerEgresosPorMes($anio, $mes)
    {
        $egresos = [];

        // Productos
        $queryProductos = "
            SELECT 
                id_producto AS id,
                fecha_compra AS fecha,
                'Producto' AS tipo,
                nombre_producto AS nombre,
                cant_productos AS cantidad,
                precio_producto AS precio,
                descripcion
            FROM egresos_productos
            WHERE YEAR(fecha_compra) = :anio AND MONTH(fecha_compra) = :mes
        ";

        $stmtProductos = $this->conn->prepare($queryProductos);
        $stmtProductos->bindParam(':anio', $anio, PDO::PARAM_INT);
        $stmtProductos->bindParam(':mes', $mes, PDO::PARAM_INT);
        $stmtProductos->execute();

        $egresos = array_merge($egresos, $stmtProductos->fetchAll(PDO::FETCH_ASSOC));

        // Servicios
        $queryServicios = "
            SELECT 
                id_servicio AS id,
                fecha_servicio AS fecha,
                'Servicio' AS tipo,
                nombre_servicio AS nombre,
                NULL AS cantidad,
                periodo_consumo AS cantidad,  -- Aquí agregamos periodo_consumo para los servicios
                precio_servicio AS precio,
                descripcion
            FROM egresos_servicios
            WHERE YEAR(fecha_servicio) = :anio AND MONTH(fecha_servicio) = :mes
        ";

        $stmtServicios = $this->conn->prepare($queryServicios);
        $stmtServicios->bindParam(':anio', $anio, PDO::PARAM_INT);
        $stmtServicios->bindParam(':mes', $mes, PDO::PARAM_INT);
        $stmtServicios->execute();

        $egresos = array_merge($egresos, $stmtServicios->fetchAll(PDO::FETCH_ASSOC));

        return $egresos;
    }

    public function editarProducto($id, $nombre, $cantidad, $precio)
    {
        $query = "
        UPDATE egresos_productos 
        SET nombre_producto = :nombre, 
            cant_productos = :cantidad, 
            precio_producto = :precio 
        WHERE id_producto = :id
    ";

        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':nombre' => $nombre,
            ':cantidad' => $cantidad,
            ':precio' => $precio,
            ':id' => $id
        ]);
    }

    public function editarServicio($id, $nombre, $periodo, $precio)
    {
        $query = "
        UPDATE egresos_servicios 
        SET nombre_servicio = :nombre, 
            periodo_consumo = :periodo, 
            precio_servicio = :precio 
        WHERE id_servicio = :id
    ";

        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':nombre' => $nombre,
            ':periodo' => $periodo,
            ':precio' => $precio,
            ':id' => $id
        ]);
    }

    /* Método para eliminar producto */
    public function eliminarProducto($id)
    {
        $query = "
            DELETE FROM egresos_productos 
            WHERE id_producto = :id
        ";

        $stmt = $this->conn->prepare($query);
        return $stmt->execute([':id' => $id]);
    }

    /* Método para eliminar servicio */
    public function eliminarServicio($id)
    {
        $query = "
            DELETE FROM egresos_servicios 
            WHERE id_servicio = :id
        ";

        $stmt = $this->conn->prepare($query);
        return $stmt->execute([':id' => $id]);
    }
}
