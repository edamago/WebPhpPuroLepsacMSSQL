<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$request = $_SERVER["REQUEST_URI"];

// Normalizar las rutas base
$baseApiProductos = "/pro-back/api/productos";
$baseApiClientes = "/pro-back/api/clientes";
$baseApiComprobantes = "/pro-back/api/comprobantes";

if (strpos($request, $baseApiComprobantes) === 0) {
    require_once __DIR__ . "/routes/comprobante/listar.php";
} elseif (strpos($request, $baseApiProductos) === 0) {
    // Extraer lo que sigue después de /pro-back/api/productos
    $rest = substr($request, strlen($baseApiProductos)); // Ejemplo: /216374MOE o vacío

    if ($rest === '' || $rest === '/') {
        // Listar todos los productos
        require_once __DIR__ . "/routes/producto/listar.php";
    } else {
        // Quitar la barra inicial /
        $codigo = ltrim($rest, '/');
        $_GET['codigo'] = $codigo;
        require_once __DIR__ . "/routes/producto/obtener.php";
    }
} elseif (strpos($request, $baseApiClientes) === 0) {
    // Extraer lo que sigue después de /pro-back/api/clientes
    $rest = substr($request, strlen($baseApiClientes)); // Ejemplo: /104XXXXXX o vacío

    if ($rest === '' || $rest === '/') {
        // Listar todos los clientes
        require_once __DIR__ . "/routes/cliente/listar.php";
    } else {
        // Quitar la barra inicial /
        $documento = ltrim($rest, '/');
        $_GET['documento'] = $documento;
        require_once __DIR__ . "/routes/cliente/obtener.php";
    }
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Ruta no encontrada."));
}
