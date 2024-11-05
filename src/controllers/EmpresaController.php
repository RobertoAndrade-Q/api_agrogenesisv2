<?php

namespace App\Controllers;

use App\Services\EmpresaService;

class EmpresaController
{
    private EmpresaService $service;
    /* 
    // Crea un método processRequest que recibe el método HTTP y el id de la empresa 
    public function processRequest(string $method, ?string $id): void
    {
        // Si el id es nulo, se ejecuta el siguiente bloque de código
        if ($id === null) {
            switch ($method) {
                case 'GET':
                    $this->getAllEmpresas();
                    break;
                default:
                    $this->respondMethodNotAllowed('GET, POST');
                    break;
            }
        } else {
            switch ($method) {
                case 'GET':
                    $this->getEmpresa((int) $id);
                    break;
                default:
                    $this->respondMethodNotAllowed('GET');
                    break;
            }
        }
    }

    public function getAllEmpresas(): void
    {
        $query = "SELECT * from ge_empresa ORDER BY CAST(codigo AS DECIMAL) DESC";

        // Ejecutar la consulta
        $result = @odbc_exec($this->connection, $query);

        // Verificar si hubo un error en la ejecución de la consulta
        if (!$result) {
            $this->respondInternalError("Error executing the query: " . odbc_errormsg($this->connection));
            return;
        }

        // Recoger resultados en un array
        $empresas = [];
        while ($row = odbc_fetch_array($result)) {
            $empresas[] = $row;
        }

        echo json_encode([
            "ok" => true,
            'data' => $empresas
        ]);
    }

    public function getEmpresa($id)
    {
        echo json_encode([
            'message' => 'getEmpresa',
            'id' => $id
        ]);
    }
 */

    public function __construct($connection)
    {
        $this->service = new EmpresaService($connection);
    }

    public function getAllEmpresas()
    {
        try {
            $empresas = $this->service->getAllEmpresas();
            // $empresasArray = array_map(fn($empresa) => $empresa->toArray(), $empresas);
            echo json_encode($empresas);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['message' => 'Error retrieving companies', 'error' => $e->getMessage()]);
        }
    }

    // Función Generales
    private function respondMethodNotAllowed(string $allowedMethods)
    {
        http_response_code(405);
        header("Allow: $allowedMethods");
        echo json_encode(['message' => 'Method not allowed']);
    }

    private function respondInternalError(string $message): void
    {
        http_response_code(500);
        echo json_encode(['message' => $message]);
    }
}
