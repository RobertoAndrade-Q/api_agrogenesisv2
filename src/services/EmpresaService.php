<?php

namespace App\Services;

use App\Repositories\EmpresaRepository;

class EmpresaService
{
    private EmpresaRepository $repository;

    public function __construct($connection)
    {
        $this->repository = new EmpresaRepository($connection);
    }

    public function getAllEmpresas(): array
    {
        try {
            return $this->repository->getAll();
        } catch (\Exception $e) {
            throw new \Exception("Could not fetch companies");
        }
    }
}
