<?php
require_once __DIR__ . "/../../controllers/ClienteApiController.php";

if (!isset($_GET['documento']) || empty(trim($_GET['documento']))) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Parámetro 'documento' es requerido."
    ]);
    exit;
}

$documento = trim($_GET['documento']);

$controller = new ClienteApiController();
$controller->obtenerCliente($documento);
