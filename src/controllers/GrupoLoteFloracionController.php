<?php

namespace App\Controllers;

use App\Services\GrupoLoteFloracionService;

class GrupoLoteFloracionController
{
    private GrupoLoteFloracionService $service;

    public function __construct(GrupoLoteFloracionService $service)
    {
        $this->service = $service;
    }

    public function processRequest(string $method, ?string $id): void
    {
        switch ($method) {
            case 'GET':
                if ($id) {
                    $this->service->getGrupo((int) $id);
                } else {
                    $this->service->getAllGrupos();
                }
                break;
            case 'POST':
                // Aquí va la lógica para crear un nuevo grupo
                $data = $_POST;
                $this->service->createGrupo($data);
                break;
            default:
                $this->respondMethodNotAllowed('GET, POST');
                break;
        }
    }

    private function respondMethodNotAllowed(string $allowedMethods): void
    {
        http_response_code(405);
        header("Allow: $allowedMethods");
        echo json_encode(['message' => 'Method not allowed']);
    }
}
