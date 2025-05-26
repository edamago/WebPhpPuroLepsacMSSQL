<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$request = $_SERVER["REQUEST_URI"];

if (strpos($request, "/prow/api/comprobantes") === 0) {
    require_once __DIR__ . "/routes/comprobante/listar.php";
} elseif (strpos($request, "/prow/api/productos") === 0) {
    require_once __DIR__ . "/routes/producto/listar.php";
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Ruta no encontrada."));
     
    echo($request); 
}
