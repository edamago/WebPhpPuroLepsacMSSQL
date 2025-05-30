<?php
require_once __DIR__ . "/../models/ClienteModel.php";

class ClienteApiController
{
    private $clienteModel;

    public function __construct()
    {
        $this->clienteModel = new ClienteModel();
    }

    /**
     * Devuelve un JSON con todos los clientes activos.
     */
    public function listar()
    {
        $clientes = $this->clienteModel->obtenerClientes();

        if (count($clientes) > 0) {
            http_response_code(200);
            echo json_encode([
                "status" => "success",
                "data" => $clientes
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                "status" => "error",
                "message" => "No se encontraron clientes."
            ]);
        }
    }

    /**
     * Devuelve un JSON con un cliente específico según el documento.
     *
     * @param string $documento
     */
    public function obtenerCliente($documento)
    {
        $cliente = $this->clienteModel->obtenerClientePorDocumento($documento);

        if ($cliente) {
            http_response_code(200);
            echo json_encode([
                "status" => "success",
                "data" => $cliente
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                "status" => "error",
                "message" => "Cliente no encontrado."
            ]);
        }
    }
}
