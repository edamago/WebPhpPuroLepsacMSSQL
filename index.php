<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$request = $_SERVER["REQUEST_URI"];

// Normalizar la ruta para que siempre empiece igual
// Ejemplo: /pro-back/api/productos/216374MOE
$baseApi = "/pro-back/api/productos";

if (strpos($request, "/pro-back/api/comprobantes") === 0) {
    require_once __DIR__ . "/routes/comprobante/listar.php";
} elseif (strpos($request, $baseApi) === 0) {
    // Extraer lo que sigue después de /pro-back/api/productos
    $rest = substr($request, strlen($baseApi)); // Ejemplo: /216374MOE o vacío si listamos todos

    if ($rest === '' || $rest === '/') {
        // Listar todos los productos
        require_once __DIR__ . "/routes/producto/listar.php";
    } else {
        // Quitamos la barra inicial /
        $codigo = ltrim($rest, '/');

        // Pasamos $codigo a la ruta que devolverá un solo producto
        // Para que esta ruta tenga acceso a $codigo, lo definimos como GET o global aquí
        $_GET['codigo'] = $codigo;

        require_once __DIR__ . "/routes/producto/obtener.php";
    }
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Ruta no encontrada."));
}
