<?php
require_once __DIR__ . "/../config/Database.php";


class ProductoModel
{
    private $conn;

    public function __construct()
    {
        $database = Database::getInstance();
        $this->conn = $database->getConnection();
    }

    /**
     * Obtiene todos los productos de la vista.
     *
     * @return array
     */
    public function obtenerProductos(): array
    {
        $sql = "
            SELECT 
                CAMPO001 AS codigo,
                CAMPO002 AS descripcion,
                CAMPO005 AS unidad_medida,
                ISNULL(Campo142, 0) AS stock_minimo,
                ISNULL(Campo143, 0) AS stock_maximo,
                ISNULL(Campo011, 0) AS peso_bruto,
                ISNULL(Campo010, 0) AS peso_neto,
                ISNULL(nAlto, 0) AS alto,
                ISNULL(nAncho, 0) AS ancho,
                ISNULL(nProfundo, 0) AS profundo,
                ISNULL(vchClasifDem, '') AS clasif_demanda,
                SUBSTRING(ISNULL(vchTipoComercial, ''), 1, 1) AS clasif_comercial,
                ISNULL(Campo019, '') AS comentarios,
                chrEstado AS estado,
                CASE chrEstado 
                    WHEN 'A' THEN 1 
                    WHEN 'I' THEN 0 
                    ELSE 0 
                END AS activo
            FROM TAB006
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
