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

        /* Productos */
        $queryProductos = "
            SELECT 
                id_producto AS id,
                fecha_compra AS fecha,
                'Producto' AS tipo_egreso,
                nombre_producto AS nombre,
                cant_productos AS cantidad,
                precio_producto AS precio,
                igv,
                tipo AS tipo_factura,
                descripcion,
                ruc,
                razon_social,
                nro_factura,
                descuento,
                tipo_producto AS tipo_origen,
                estado
            FROM egresos_productos
            WHERE YEAR(fecha_compra) = :anio AND MONTH(fecha_compra) = :mes
        ";

        $stmtProductos = $this->conn->prepare($queryProductos);
        $stmtProductos->bindParam(':anio', $anio, PDO::PARAM_INT);
        $stmtProductos->bindParam(':mes', $mes, PDO::PARAM_INT);
        $stmtProductos->execute();

        $egresos = array_merge($egresos, $stmtProductos->fetchAll(PDO::FETCH_ASSOC));

        /* Servicios */
        $queryServicios = "
            SELECT 
                id_servicio AS id,
                fecha_servicio AS fecha,
                'Servicio' AS tipo_egreso,
                nombre_servicio AS nombre,
                periodo_consumo AS cantidad,
                precio_servicio AS precio,
                igv,
                tipo AS tipo_factura,
                descripcion,
                ruc,
                razon_social,
                nro_factura,
                tipo_servicio AS tipo_origen,
                estado
            FROM egresos_servicios
            WHERE YEAR(fecha_servicio) = :anio AND MONTH(fecha_servicio) = :mes
        ";

        $stmtServicios = $this->conn->prepare($queryServicios);
        $stmtServicios->bindParam(':anio', $anio, PDO::PARAM_INT);
        $stmtServicios->bindParam(':mes', $mes, PDO::PARAM_INT);
        $stmtServicios->execute();

        $egresos = array_merge($egresos, $stmtServicios->fetchAll(PDO::FETCH_ASSOC));

        /* Consumo */
        $queryConsumo = "
            SELECT 
                id_consumo AS id,
                fecha_consumo AS fecha,
                'Consumo' AS tipo_egreso,
                nombre_consumo AS nombre,
                cant_consumo AS cantidad,
                precio_consumo AS precio,
                igv,
                tipo AS tipo_factura,
                descripcion,
                ruc,
                razon_social,
                nro_factura,
                tipo_consumo AS tipo_origen,
                estado
            FROM egresos_consumo
            WHERE YEAR(fecha_consumo) = :anio AND MONTH(fecha_consumo) = :mes
        ";

        $stmtConsumo = $this->conn->prepare($queryConsumo);
        $stmtConsumo->bindParam(':anio', $anio, PDO::PARAM_INT);
        $stmtConsumo->bindParam(':mes', $mes, PDO::PARAM_INT);
        $stmtConsumo->execute();

        $egresos = array_merge($egresos, $stmtConsumo->fetchAll(PDO::FETCH_ASSOC));

        /* Transferencias */
        $queryTransferencia = "
            SELECT 
                id_transferencia AS id,
                fecha_transferencia AS fecha,
                'Transferencia' AS tipo_egreso,
                detalle_transferencia AS nombre,
                NULL AS cantidad,
                monto_transferencia AS precio,
                NULL AS igv,
                tipo AS tipo_factura,
                NULL AS descripcion,
                dni_transferencia AS ruc,
                razon_social,
                nro_factura,
                tipo_transferencia AS tipo_origen,
                'activo' AS estado
            FROM egresos_transferencia
            WHERE YEAR(fecha_transferencia) = :anio AND MONTH(fecha_transferencia) = :mes
        ";

        $stmtTransferencia = $this->conn->prepare($queryTransferencia);
        $stmtTransferencia->bindParam(':anio', $anio, PDO::PARAM_INT);
        $stmtTransferencia->bindParam(':mes', $mes, PDO::PARAM_INT);
        $stmtTransferencia->execute();

        $egresos = array_merge($egresos, $stmtTransferencia->fetchAll(PDO::FETCH_ASSOC));


        return $egresos;
    }


    public function editarProducto($id, $nombre, $cantidad, $precio, $igv)
    {
        $query = "
        UPDATE egresos_productos 
        SET nombre_producto = :nombre, 
            cant_productos = :cantidad, 
            precio_producto = :precio,
            igv = :igv 
        WHERE id_producto = :id
    ";

        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':nombre' => $nombre,
            ':cantidad' => $cantidad,
            ':precio' => $precio,
            ':igv' => $igv,
            ':id' => $id
        ]);
    }

    public function editarServicio($id, $nombre, $periodo, $precio, $igv)
    {
        $query = "
        UPDATE egresos_servicios 
        SET nombre_servicio = :nombre, 
            periodo_consumo = :periodo, 
            precio_servicio = :precio,
            igv = :igv
        WHERE id_servicio = :id
    ";

        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':nombre' => $nombre,
            ':periodo' => $periodo,
            ':precio' => $precio,
            ':igv' => $igv,
            ':id' => $id
        ]);
    }

    public function editarConsumo($id, $nombre, $periodo, $precio, $igv)
    {
        $query = "
        UPDATE egresos_consumo 
        SET nombre_consumo = :nombre, 
            cant_consumo = :periodo, 
            precio_consumo = :precio,
            igv = :igv
        WHERE id_consumo = :id
    ";

        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':nombre' => $nombre,
            ':periodo' => $periodo,
            ':precio' => $precio,
            ':igv' => $igv,
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

    /* Método para eliminar consumo */
    public function eliminarConsumo($id)
    {
        $query = "
            DELETE FROM egresos_consumo 
            WHERE id_consumo = :id
        ";

        $stmt = $this->conn->prepare($query);
        return $stmt->execute([':id' => $id]);
    }
}
