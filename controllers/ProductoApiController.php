<?php
//require_once __DIR__ . '/../../models/ProductoModel.php';
require_once __DIR__ . "/../models/ProductoModel.php";


class ProductoApiController
{
    private $productoModel;

    public function __construct()
    {
        $this->productoModel = new ProductoModel();
    }

    /**
     * Devuelve un JSON con todos los productos.
     */
    public function listar()
    {
        $productos = $this->productoModel->obtenerProductos();

        if (count($productos) > 0) {
            http_response_code(200);
            echo json_encode([
                "status" => "success",
                "data" => $productos
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                "status" => "error",
                "message" => "No se encontraron productos."
            ]);
        }
    }
}
