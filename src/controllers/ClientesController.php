<?php

namespace App\Controllers;

use App\Services\ClienteService;

class ClientesController
{
    private ClienteService $service;


    public function __construct($connection)
    {
        $this->service = new ClienteService($connection);
    }

    /*  public function buscar()
    {
        $empresa = $_GET['empresa'] ?? null;
        $filtro = $_GET['filtro'] ?? null;
        $criterio = $_GET['criterio'] ?? null;
        $iniciarDesde = $_GET['iniciarDesde'] ?? null;

        try {
            $clientes = $this->service->buscarClientes($empresa, $filtro, $criterio, $iniciarDesde);
            echo json_encode(['success' => true, 'data' => $clientes]);
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'msg' => $e->getMessage()]);
        }
    } */

    public function buscar()
    {
        $empresa = $_GET['empresa'] ?? null;
        $filtro = $_GET['filtro'] ?? null;
        $criterio = $_GET['criterio'] ?? null;
        $iniciarDesde = $_GET['iniciarDesde'] ?? null;

        try {
            $clientes = $this->service->buscarClientes($empresa, $filtro, $criterio, $iniciarDesde);
            echo json_encode(['success' => true, 'data' => $clientes]);
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    public function obtenerNuevoCodigo()
    {
        $empresa = $_GET['empresa'] ?? null;

        try {
            $codigo = $this->service->obtenerNuevoCodigoCliente($empresa);
            echo json_encode(['success' => true, 'codigo' => $codigo]);
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    public function consultarWebServiceGenesis()
    {
        $cedula = $_GET['cedula'] ?? null;
        $empresa = $_GET['empresa'] ?? null;

        try {
            $resultado = $this->service->consultaWebServiceGenesis($cedula, $empresa);
            echo json_encode(['success' => true, 'result' => $resultado]);
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    // Función Generales
    private function respondMethodNotAllowed(string $allowedMethods)
    {
        http_response_code(405);
        header("Allow: $allowedMethods");
        echo json_encode(['message' => 'Método no implementado']);
    }

    private function respondInternalError(string $message): void
    {
        http_response_code(500);
        echo json_encode(['message' => $message]);
    }
}
