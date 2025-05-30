<?php
require_once __DIR__ . "/../config/Database.php";

class ClienteModel
{
    private $conn;

    public function __construct()
    {
        $database = Database::getInstance();
        $this->conn = $database->getConnection();
    }

    /**
     * Obtiene todos los clientes activos.
     *
     * @return array
     */
    public function obtenerClientes(): array
    {
        $sql = "
            SELECT 
                SUBSTRING(TipoDoc.Nombre, 1, 1) AS tipo_documento,
                CAST(CAST(ISNULL(a.Campo004,'') AS NUMERIC) AS VARCHAR) AS documento,
                ISNULL(a.Campo002, '') AS nombre,
                ISNULL(a.Campo003, '') AS direccion,
                ISNULL(a.Campo003, '') AS direccion_entrega,
                ISNULL(a.Campo033, '') AS distrito,
                ISNULL(a.Campo044, '') AS ciudad,
                ISNULL(TipoCliente.Nombre, '') AS tipo,
                SUBSTRING(ISNULL(vchTipo, ''), 1, 1) AS clasif_comercial,
                ISNULL(a.Campo039, '') AS comentarios,
                ISNULL(a.Campo010, '') AS estado,
                CASE a.Campo010 
                    WHEN 'A' THEN 1 
                    ELSE 0 
                END AS activo
            FROM TAB020 a
            LEFT JOIN (
                SELECT CAMPO002 AS Codigo, CAMPO003 AS Nombre
                FROM TAB003
                WHERE CAMPO001 = 121
            ) TipoDoc ON TipoDoc.Codigo = a.nTipDocId
            LEFT JOIN (
                SELECT CAMPO002 AS Codigo, CAMPO003 AS Nombre
                FROM TAB003
                WHERE CAMPO001 = 72
            ) TipoCliente ON TipoCliente.Codigo = a.Campo027
             WHERE a.Campo010='A'         
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene un cliente por su documento.
     *
     * @param string $documento
     * @return array|false
     */
    public function obtenerClientePorDocumento(string $documento)
    {
        $sql = "
            SELECT 
                SUBSTRING(TipoDoc.Nombre, 1, 1) AS tipo_documento,
                CAST(CAST(ISNULL(a.Campo004,'') AS NUMERIC) AS VARCHAR) AS documento,
                ISNULL(a.Campo002, '') AS nombre,
                ISNULL(a.Campo003, '') AS direccion,
                ISNULL(a.Campo003, '') AS direccion_entrega,
                ISNULL(a.Campo033, '') AS distrito,
                ISNULL(a.Campo044, '') AS ciudad,
                ISNULL(TipoCliente.Nombre, '') AS tipo,
                SUBSTRING(ISNULL(vchTipo, ''), 1, 1) AS clasif_comercial,
                ISNULL(a.Campo039, '') AS comentarios,
                ISNULL(a.Campo010, '') AS estado,
                CASE a.Campo010 
                    WHEN 'A' THEN 1 
                    ELSE 0 
                END AS activo
            FROM TAB020 a
            LEFT JOIN (
                SELECT CAMPO002 AS Codigo, CAMPO003 AS Nombre
                FROM TAB003
                WHERE CAMPO001 = 121
            ) TipoDoc ON TipoDoc.Codigo = a.nTipDocId
            LEFT JOIN (
                SELECT CAMPO002 AS Codigo, CAMPO003 AS Nombre
                FROM TAB003
                WHERE CAMPO001 = 72
            ) TipoCliente ON TipoCliente.Codigo = a.Campo027
            WHERE a.Campo004 = :documento
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':documento', $documento, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
