<?php

namespace App\Services;

use App\Repositories\ClienteRepository;

class ClienteService
{
    private ClienteRepository $repository;

    public function __construct($connection)
    {
        $this->repository = new ClienteRepository($connection);
    }

    private function codificar(array $data): array
    {
        return array_map(fn($value) => utf8_encode($value), $data);
    }

    public function buscarClientes($empresa, $filtro, $criterio, $iniciarDesde): array
    {
        $clientes = $this->repository->buscarClientes($empresa, $filtro, $criterio, $iniciarDesde);
        return array_map([$this, 'codificar'], $clientes);
    }

    public function obtenerNuevoCodigoCliente($empresa): int
    {
        return $this->repository->nuevoCodigoCliente($empresa);
    }

    public function consultaWebServiceGenesis($cedula, $empresa): bool
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'http://sistemasgenesis.com.ec:2001/persona/' . $cedula,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        $data = json_decode($response, true);
        if ($data) {
            $codigo = $this->obtenerNuevoCodigoCliente($empresa);
            $cedula_ruc = $data['cedula_ruc'] ?? $cedula;
            $nombre = utf8_decode($data['nombre']);
            // Lógica para insertar en la base de datos
            return true;
        }
        return false;
    }
}
