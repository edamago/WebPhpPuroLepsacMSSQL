<?php
require_once __DIR__ . '/config.php';

class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    private static $instance = null;
    private $conn;

    private function __construct() {
        $config = require __DIR__ . '/config.php';
        $this->host = $config['db']['host'];
        $this->db_name = $config['db']['name'];
        $this->username = $config['db']['user'];
        $this->password = $config['db']['password'];

        try {
            // Opción para SQL Server
            $dsn = "sqlsrv:Server={$this->host};Database={$this->db_name}";

            $this->conn = new PDO($dsn, $this->username, $this->password);

            // Establecer el modo de errores
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            error_log("Database connection error: " . $e->getMessage());

            // Mensaje más detallado y directo en pantalla
            die("<h2>Error de conexión a la base de datos</h2><p>" . $e->getMessage() . "</p>");
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }

    private function __clone() {}

    public function __wakeup() {
        throw new Exception("Deserialización no permitida.");
    }
}
