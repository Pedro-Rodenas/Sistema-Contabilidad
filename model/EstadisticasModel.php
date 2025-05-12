<?php
require_once __DIR__ . "/../config/database.php";

class EstadisticasModel
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getMesMasGasto($ano)
    {
        $sql = "
            SELECT MONTHNAME(fecha) as mes, SUM(total) as total
            FROM (
                SELECT fecha_compra as fecha, precio_producto as total
                FROM egresos_productos
                WHERE estado = 'activo' AND YEAR(fecha_compra) = :ano

                UNION ALL

                SELECT fecha_servicio as fecha, precio_servicio as total
                FROM egresos_servicios
                WHERE estado = 'activo' AND YEAR(fecha_servicio) = :ano

                UNION ALL
                
                SELECT fecha_consumo as fecha, precio_consumo as total
                FROM egresos_consumo
                WHERE estado = 'activo' AND YEAR(fecha_consumo) = :ano
            ) AS egresos
            GROUP BY mes
            ORDER BY total DESC
            LIMIT 1
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':ano', $ano, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['mes'] ?? null;
    }

    public function getMesMenosGasto($ano)
    {
        $sql = "
            SELECT MONTHNAME(fecha) as mes, SUM(total) as total
            FROM (
                SELECT fecha_compra as fecha, precio_producto as total
                FROM egresos_productos
                WHERE estado = 'activo' AND YEAR(fecha_compra) = :ano

                UNION ALL

                SELECT fecha_servicio as fecha, precio_servicio as total
                FROM egresos_servicios
                WHERE estado = 'activo' AND YEAR(fecha_servicio) = :ano

                UNION ALL

                SELECT fecha_consumo as fecha, precio_consumo as total
                FROM egresos_consumo
                WHERE estado = 'activo' AND YEAR(fecha_consumo) = :ano

            ) AS egresos
            GROUP BY mes
            HAVING total > 0
            ORDER BY total ASC
            LIMIT 1
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':ano', $ano, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['mes'] ?? null;
    }

    public function getEgresoMasCaro($ano)
    {
        $sql = "
        SELECT nombre, MAX(total) as total
        FROM (
            -- Productos
            SELECT nombre_producto AS nombre, precio_producto AS total
            FROM egresos_productos
            WHERE estado = 'activo' AND YEAR(fecha_compra) = :ano

            UNION ALL

            -- Consumos
            SELECT nombre_consumo AS nombre, precio_consumo AS total
            FROM egresos_consumo
            WHERE estado = 'activo' AND YEAR(fecha_consumo) = :ano

            UNION ALL

            -- Servicios
            SELECT nombre_servicio AS nombre, precio_servicio AS total
            FROM egresos_servicios
            WHERE estado = 'activo' AND YEAR(fecha_servicio) = :ano
        ) AS egresos
        GROUP BY nombre
        ORDER BY total DESC
        LIMIT 1
    ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':ano', $ano, PDO::PARAM_INT);
        $stmt->execute();

        // Obtener el nombre del egreso más caro
        return $stmt->fetch(PDO::FETCH_ASSOC)['nombre'] ?? null;
    }


    public function getEgresosPorMes($ano)
    {
        $sql = "
        SELECT MONTHNAME(fecha) AS mes, SUM(total) AS total
        FROM (
            SELECT fecha_compra AS fecha, precio_producto AS total
            FROM egresos_productos
            WHERE estado = 'activo' AND YEAR(fecha_compra) = :ano

            UNION ALL

            SELECT fecha_servicio AS fecha, precio_servicio AS total
            FROM egresos_servicios
            WHERE estado = 'activo' AND YEAR(fecha_servicio) = :ano

            UNION ALL

            SELECT fecha_consumo AS fecha, precio_consumo AS total
            FROM egresos_consumo
            WHERE estado = 'activo' AND YEAR(fecha_consumo) = :ano

        ) AS egresos
        GROUP BY mes
        ORDER BY MONTH(fecha)
    ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':ano', $ano, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDistribucionEgresosPorTipo($ano)
    {
        $sql = "
        SELECT 'Productos' AS tipo, SUM(precio_producto) AS total
        FROM egresos_productos
        WHERE estado = 'activo' AND YEAR(fecha_compra) = :ano

        UNION ALL

        SELECT 'Servicios' AS tipo, SUM(precio_servicio) AS total
        FROM egresos_servicios
        WHERE estado = 'activo' AND YEAR(fecha_servicio) = :ano

        UNION ALL
        
        SELECT 'Consumo' AS tipo, SUM(precio_consumo) AS total
        FROM egresos_consumo
        WHERE estado = 'activo' AND YEAR(fecha_consumo) = :ano

    ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':ano', $ano, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
