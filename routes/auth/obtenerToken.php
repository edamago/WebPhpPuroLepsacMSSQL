<?php
//require_once __DIR__ . "/../services/TokenService.php";
require_once __DIR__ . '/../../services/TokenService.php';

try {
    $tokenService = new TokenService();
    $token = $tokenService->obtenerToken();
    echo json_encode(["access_token" => $token]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}
