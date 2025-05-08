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

    public function getProductoMasCaro($ano)
    {
        $sql = "
            SELECT nombre_producto, MAX(precio_producto) as total
            FROM egresos_productos
            WHERE estado = 'activo' AND YEAR(fecha_compra) = :ano
            GROUP BY nombre_producto
            ORDER BY total DESC
            LIMIT 1
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':ano', $ano, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['nombre_producto'] ?? null;
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
    ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':ano', $ano, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getComparacionAnual($ano)
    {
        $sql = "
            SELECT SUM(total) as total, ano FROM (
                SELECT precio_producto as total, YEAR(fecha_compra) as ano
                FROM egresos_productos
                WHERE estado = 'activo' AND YEAR(fecha_compra) IN (:ano_actual, :ano_anterior)
                UNION ALL
                SELECT precio_servicio as total, YEAR(fecha_servicio) as ano
                FROM egresos_servicios
                WHERE estado = 'activo' AND YEAR(fecha_servicio) IN (:ano_actual, :ano_anterior)
            ) AS egresos
            GROUP BY ano
        ";

        $stmt = $this->conn->prepare($sql);
        $ano_anterior = $ano - 1;
        $stmt->bindParam(':ano_actual', $ano, PDO::PARAM_INT);
        $stmt->bindParam(':ano_anterior', $ano_anterior, PDO::PARAM_INT);
        $stmt->execute();

        $totales = [
            'actual' => 0,
            'anterior' => 0
        ];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ((int)$row['ano'] === (int)$ano) {
                $totales['actual'] = (float)$row['total'];
            } else {
                $totales['anterior'] = (float)$row['total'];
            }
        }

        return $totales;
    }
}
