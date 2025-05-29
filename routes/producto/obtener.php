<?php
require_once __DIR__ . "/../../controllers/ProductoApiController.php";

if (!isset($_GET['codigo']) || empty(trim($_GET['codigo']))) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Parámetro 'codigo' es requerido."
    ]);
    exit;
}

$codigo = trim($_GET['codigo']);

$controller = new ProductoApiController();
$controller->obtenerProducto($codigo);
