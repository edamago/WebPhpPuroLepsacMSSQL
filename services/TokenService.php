<?php
class TokenService {
    private $urlLogin = "https://www.lepsac.net.pe/pro/api/auth/login";
    private $usuario = "admin";
    private $clave = "12345"; // O la clave correcta

    public function obtenerToken() {
        $data = [
            'usuario' => $this->usuario,
            'clave' => $this->clave
        ];

        $options = [
            'http' => [
                'header'  => "Content-Type: application/json\r\n",
                'method'  => 'POST',
                'content' => json_encode($data),
            ],
        ];
        $context  = stream_context_create($options);
        $result = file_get_contents($this->urlLogin, false, $context);

        if ($result === false) {
            throw new Exception('❌ Error al obtener el token (falló la llamada a la API externa).');
        }

        $response = json_decode($result, true);

        if (!$response) {
            throw new Exception('❌ La respuesta no es JSON válido: ' . $result);
        }

        // ✅ Si la respuesta tiene un campo "error"
        if (isset($response['error'])) {
            return [
                'success' => false,
                'message' => $response['error']
            ];
        }

        // ✅ Si la respuesta tiene un campo "token"
        if (isset($response['token'])) {
            return [
                'success' => true,
                'message' => '✅ Token obtenido correctamente',
                'token' => $response['token']
            ];
        }

        // ⚠️ Si no vino ni error ni token, es una respuesta inesperada
        return [
            'success' => false,
            'message' => '❌ Respuesta inesperada de la API: ' . $result
        ];
    }
}
?>

